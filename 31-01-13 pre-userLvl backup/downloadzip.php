<?php
include_once("connection.php");// connects to the database
include_once("prp_functions.php");
check_access(); // redirects user if not logged in
?>
<?php //multiple upload php was written by Paul.
function AllFileFieldsEmpty()
{
	$allEmpty = true;
	foreach($_FILES["userfile"]["error"] as $key => $error)
	{
		if( $error != UPLOAD_ERR_NO_FILE )
		{
			$allEmpty = false;
			break;
		}
	}
	return $allEmpty;
}
// function attempts to upload all given files found in $_FILES array
// returns a single string representing errors
// each error is seperated by a newline '\n  character
// an empty error string indicates there were no problems
function UploadMultipleData()
{
	$allErrors = "";
	if( !isset($_POST["uploadsubmit"]) )
	{
		return $allErrors; // not submitted, do nothing
	}
	// get username and current date/time from server
	// needed so they can be stored in db after user has finished uploading.
	$current_user=$_SESSION["username"];
	//note database stores year,month, day. y=year,n=month,j=day
	$date = date('y,n,j');
	/* $_FILES mulit-dimanesional array structered as:
			$_FILES[fieldname] => array(
				[name] => array(  )
				[type] => array(  )
				[tmp_name] => array(  )
				[error] => array(  )
				[size] => array(  )
			);
	*/
	// loops through all uploaded files found in $_FILES
	// skips the current file if there was a problem
	//connectdb();
	$allowedTypes = array("png","gif","jpg", "jpeg", "jpe","psd","tif", "tiff","tga","bmp", "dib", "rle","wbmp", "wbm","ai", "art","eps");
	foreach($_FILES["userfile"]["error"] as $key => $error) // for every file
	{ // $key is equivalant to [i] in c++, $error is current value of ["error"]
		$fileName = $_FILES["userfile"]["name"][$key];
		if($error == UPLOAD_ERR_OK)
		{
			$tmpFileName = $_FILES["userfile"]["tmp_name"][$key];
			// security measure, check file was uploaded via HTTP POST
			if( !is_uploaded_file($tmpFileName) )
			{
				$allErrors .= "File #".($key+1)." '$fileName': not uploaded. File wasn't uploaded via HTTP POST (Possible hack attempt).\n";
				continue; // skip this file as it is not safe
			}
			// check file not empty
			if( !($_FILES["userfile"]["size"]>0) )
			{
				$allErrors .= "File #".($key+1)." '$fileName': not uploaded. File is empty.\n";
				continue; // skip this file as it is empty
			}
			// check that the file is an image, using the insecure MIME type provided by the web browser
			$mimeType = $_FILES["userfile"]["type"][$key];
			if(strpos($mimeType, "image") === false)
			{
				$allErrors .= "File #".($key+1)." '$fileName': not uploaded. File is not an image\n";
				continue; // skip this file as it is not an image
			}
			// double check that the file is an image, use the file extension
			$fileExtension = strtolower(pathinfo($fileName,PATHINFO_EXTENSION)); // get lower case version of file exstenion
			if( !in_array($fileExtension, $allowedTypes) )
			{// display all allowed file types
				$allErrors .= "File #".($key+1)." '$fileName': not uploaded. File is not a supported image (";
				for($loopCount = 0; $loopCount < count($allowedTypes); $loopCount++)
				{
					$allErrors .= $allowedTypes[$loopCount];
					if( $loopCount < (count($allowedTypes)-1) )
					{
						$allErrors .= ", ";
					}
				}
				$allErrors .= ").\n";
				continue; // skip this file as it is not an image
			}
			// --> FINALLY WORK ON THE FILE
			$theblob = addslashes(file_get_contents($_FILES["userfile"]["tmp_name"][$key]));
			$fileNameOnly = pathinfo($fileName, PATHINFO_FILENAME); // get original file name
			//add file data and username into database, time needs adding.
			$updateDB=mysql_query("INSERT INTO filestores ( username, date, filename, file, extension ) VALUES('$current_user', '$date','$fileNameOnly','$theblob','$fileExtension' )");
		}else{
			// info on values of $_FILES[fieldname][errors] at:
			// http://php.net/manual/en/features.file-upload.errors.php
			if ($error != UPLOAD_ERR_NO_FILE)
			{
				$allErrors .= "File #".($key+1)." '$fileName': not uploaded. ";
			}
			switch($error)
			{
				case UPLOAD_ERR_INI_SIZE:
					$allErrors .= "File exceeds the upload_max_filesize directive in php.ini.\n";
					break;
				case UPLOAD_ERR_FORM_SIZE:
					$allErrors .= "File exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.\n";
					break;
				case UPLOAD_ERR_PARTIAL:
					$allErrors .= "File was only partially uploaded.\n";
					break;
				case UPLOAD_ERR_NO_FILE:
					// the JavaScript addition of a row at the end guaruntees a form field will be empty
					// $allErrors .= "No file was uploaded.\n";
					break;
				case UPLOAD_ERR_NO_TMP_DIR:
					$allErrors .= "Missing a temporary folder.\n";
					break;
				case UPLOAD_ERR_CANT_WRITE:
					$allErrors .= "Failed to write file to disk.\n";
					break;
				case UPLOAD_ERR_EXTENSION:
					$allErrors .= "A PHP extension stopped the file upload.\n";
					break;
				default:
					$allErrors .= "An error occured. Error code: $error. This should not happen!\n";
					break;
			}
		}
	}
	return $allErrors;
}
?>
<?php
mysql_select_db($database, $connection);
//List files from server which is to be shown in table.
$db_query = "SELECT id,date,username,filename,extension FROM filestores";
$db_check = mysql_query($db_query, $connection) or die(mysql_error());
$db_rows = mysql_fetch_assoc($db_check);
$db_get_rows = mysql_num_rows($db_check);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Download Area</title>
<script src="jquery.js"> </script>
<script type="text/javascript">
$(document).ready(function()
{
	$('input[type=checkbox]').change(function()
	{
		var fileid=$('input[type=checkbox]:checked').val();
		$('input#file_ident').val(fileid);
	});
	$("#selectfile2").change(function()
	{
		if( $(".selectfile").attr("checked") )
		{
			$(".selectfile").removeAttr("checked");
		}else{
			$(".selectfile").attr("checked", "checked");
		}
	});
	$("#dlBTN").click(function()
	{
		var fileIdString = "fileid=";
		$(".selectfile").each(function()
		{// all checkboxes
			if( $(this).is(":checked") )
			{// each checked checkbox
				var currentTR =  $(this.parentNode.parentNode);
				// get value of ID field on current row
				var idValue = currentTR.find(".idcolumn").html()
				fileIdString += idValue + ",";
			}
		});
		if(fileIdString != "fileid=")
		{// 1 or more files ready to put in URL
			if( fileIdString[fileIdString.length-1] == "," )
			{// remove the trailing ','
				fileIdString = fileIdString.substr(0, fileIdString.length-1);
			}
			// re-direct to the processing .php with ?fileId=id1,id2,id3,id4 etc
			$("#dlBTN").attr("onclick", document.location.href="zippingfiles.php?" + fileIdString);
		}
		//var linkid=$('input#file_ident').val();
	});
});
</script>

<script type="text/javascript"> // written by Paul.
	// JavaScript for adding/removing file input rows
	function addRowToBottom(inputElement)
	{
		var givenRow = inputElement.parentNode.parentNode; // <tr> element
		var table = document.getElementById("fileFields");
		var allRows =  table.rows;
		var numRows = allRows.length;
		if( document.getElementById("uploadstatusdisplay") != null)
		{ // the row added by the PHP is not an input field, so doesn't count
			numRows = numRows - 1;
		}
		if(givenRow.rowIndex == numRows-1)
		{
			// get contents of last row
			var lastRowCell1HTML = allRows[numRows-1].cells[0].innerHTML;
			var lastRowCell2HTML = allRows[numRows-1].cells[1].innerHTML;
			// create the new row and cells
			var newRow = table.insertRow(numRows);
			var cell1 = newRow.insertCell(0);
			var cell2 = newRow.insertCell(1);
			var cell3 = newRow.insertCell(2);
			// populate with data
			cell1.innerHTML = lastRowCell1HTML;
			cell2.innerHTML = lastRowCell2HTML;
			cell3.innerHTML = "<input type=\"button\" onclick=\"deleteGivenRow(this)\" value=\"Delete\"/>";
		}
	}
	function deleteGivenRow(inputElement)
	{
		var givenRow = inputElement.parentNode.parentNode;
		var table = document.getElementById("fileFields");
		var newRow = table.deleteRow(givenRow.rowIndex);
	}
</script>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php
include ("header.php");
?>
<input type="hidden" id="file_ident[]"/>
<table class="DLList">
	<tr>
		<td width="5">id</td>
		<td width="146">username</td>
		<td width="45">date</td>
		<td width="138">filename</td>
		<td width="5">extension</td>
		<td width="130"><INPUT TYPE="BUTTON" id="dlBTN" VALUE="Download"/></td>
	</tr>
    <td width="5"><input type="text" id="txt1" size="5"/></td>
    <td width="146"><input type="text" id="txt2"/></td>
    <td width="45"><input type="text" id="txt3"/></td>
    <td width="138"><input type="text" id="txt4"/></td>
    <td width="5"><input type="text" id="txt5" size="5"/></td>
    <td width="130">Select All&nbsp&nbsp;                       
    <input type="checkbox" name="selectfile2" id="selectfile2" accesskey="2" tabindex="2" value="2" /></td> 
   
<?php  do { $file=$db_rows['id'];  ?>
    <tr>
	    <td class="idcolumn"><?php echo $file; ?></td>
	    <td><?php echo $db_rows['username']; ?></td>
	    <td><?php echo $db_rows['date']; ?></td>
	    <td><?php echo $db_rows['filename']; ?></td>
	    <td><?php echo $db_rows['extension']; ?></td>
	    <td><label form="selectfile">Select File</label>
	    <input type="checkbox" name="usrfiles[]" class="selectfile" accesskey="2" tabindex="1" onclick="" value="<?php echo $file; ?>" /></td>
    </tr>
    <?php }while ($db_rows = mysql_fetch_assoc($db_check)); ?>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<div id="upload">
	<!--html upload form was written by Paul-->
	<form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
		<!-- <input type="hidden" name="MAX_FILE_SIZE" value="102400" /> not supported by any browsers-->
		<table id="fileFields">
			<!--<tr>
				<td width="50">Add Multple Files:<br/>(Browser must support HTML5) </td>
				<td width="214"><input type="file" name="userfile[]" multiple="multiple"/></td>
			</tr>-->
			<tr>
				<td width="50">Add File: </td>
				<td width="214"><input type="file" name="userfile[]" onchange="addRowToBottom(this)"/></td>
			</tr>
			<?php
				// form processing and error message display
				if( isset($_POST["uploadsubmit"]) )
				{// form has been submitted
					echo "<tr id=\"uploadstatusdisplay\">\n";
					echo "	<td></td>\n";
					echo "	<td>";
					if( AllFileFieldsEmpty() )
					{// form is empty
						echo "<p>No files were given.</p>\n";
					}else{ // worth processing as it isn't empty
						$errors = "";
						$errors = UploadMultipleData();
						if( empty($errors) )
						{// no problems during upload
							echo "<p>Upload of all files successfull</p>";
						}else{
							// display errors
							echo "<p>The following errors were encountered when uploading your files:</p>\n";
							echo "<p>";
							echo nl2br($errors); // output string with all  ' \n ' characters replaced with <br/>
							echo "</p>";
						}
					}
					echo "</td>\n";
					echo "</tr>\n";
				}
			?>
		</table>
		<input type="submit" name="uploadsubmit" value="Submit" />
	</form>
</div>
</body>
</html>
<?php
mysql_free_result($db_check);
?>