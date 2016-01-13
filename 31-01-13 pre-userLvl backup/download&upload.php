<?php include_once("prp_connect.php");// connects to the database
include_once("prp_functions.php");//check_access(); redirect code, not of used during testing (wrong file path to home.php)

?>
<?php
session_start();
if(!isset($_POST["submit"]))
{
	die("ERROR: The form has not been submitted!");
}

$current_user=$_SESSION["username"];
$date = date('y,n,j');//get current date from server, so it can be stored in db after user has finished uploading.
//note database stores year,month, day. y=year,n=month,j=day
//connectdb();
error_reporting(E_ALL); // display any errors

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
$allowedTypes = array("png"
				,"gif"
				,"jpg", "jpeg", "jpe"
				,"psd"
				,"tif", "tiff"
				,"tga"
				,"bmp", "dib", "rle"
				,"wbmp", "wbm"
				,"ai", "art"
				,"eps");
foreach($_FILES["userfile"]["error"] as $key => $error) // for every file
{ // $key is equivalant to [i] in c++, $error is current value of ["error"]
	$fileName = $_FILES["userfile"]["name"][$key];
	echo "File #" . ($key+1) . " '$fileName': ";
	if($error == UPLOAD_ERR_OK)
	{
		$tmpFileName = $_FILES["userfile"]["tmp_name"][$key];
		// security measure, check file was uploaded via HTTP POST
		if(!is_uploaded_file($tmpFileName))
		{
			echo "<b>Not uploaded.</b> Reason: File wasn't uploaded via HTTP POST (Possible hack attempt).<br/>";
			continue; // skip this file as it is not safe
		}
		// check file not empty
		if(!($_FILES["userfile"]["size"]>0))
		{
			echo "<b>Not uploaded.</b> Reason: File is empty.<br/>";
			continue;
		}
		// check that the file is an image, using the insecure MIME type provided by the web browser
		$mimeType = $_FILES["userfile"]["type"][$key];
		if(strpos($mimeType, "image") === false)
		{
			echo "<b>Not uploaded.</b> Reason: File is not an image.<br/>";
			continue;
		}
		// double check that the file is an image, use the file extension
		$fileExtension=strtolower(pathinfo($fileName,PATHINFO_EXTENSION)); // get lower case version of file exstenion
		if( !in_array($fileExtension, $allowedTypes) )
		{
			echo "<b>Not uploaded.</b> Reason: File is not a supported image. Allowed types (";
			for($loopCount = 0; $loopCount < count($allowedTypes); $loopCount++)
			{
				echo ".$allowedTypes[$loopCount]";
				if( $loopCount < (count($allowedTypes)-1) )
				{
					echo ", ";
				}
			}
			echo ") <br/>";
			continue;
		}
		// --> FINALLY WORK ON THE FILE
		$theblob=addslashes(file_get_contents($_FILES["userfile"]["tmp_name"][$key]));
		$fileNameOnly=pathinfo($fileName, PATHINFO_FILENAME); // get original file name
		//add file data and username into database, time needs adding.
		$updateDB=mysql_query("INSERT INTO filestores ( username, date, filename, file, extension ) VALUES('$current_user', '$date','$fileNameOnly','$theblob','$fileExtension' )");
		echo "SUCCESS. <br/>";
	}else{
		// info on values of $_FILES[fieldname][errors] at:
		// http://php.net/manual/en/features.file-upload.errors.php
		echo "<b>Not uploaded.</b> Reason: ";
		switch($error)
		{
			case UPLOAD_ERR_INI_SIZE:
				echo " the uploaded file exceeds the upload_max_filesize directive in php.ini.<br/>";
				break;
			case UPLOAD_ERR_FORM_SIZE:
				echo " the uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.<br/>";
				break;
			case UPLOAD_ERR_PARTIAL:
				echo " the uploaded file was only partially uploaded.<br/>";
				break;
			case UPLOAD_ERR_NO_FILE:
				echo " no file was uploaded.<br/>";
				break;
			case UPLOAD_ERR_NO_TMP_DIR:
				echo " missing a temporary folder. Introduced in PHP 4.3.10 and PHP 5.0.3.<br/>";
				break;
			case UPLOAD_ERR_CANT_WRITE:
				echo " failed to write file to disk. Introduced in PHP 5.1.0.<br/>";
				break;
			case UPLOAD_ERR_EXTENSION:
				echo " a PHP extension stopped the file upload. PHP does not provide a way to ascertain which extension caused the file upload to stop; examining the list of loaded extensions with phpinfo() may help. Introduced in PHP 5.2.0.<br/>";
				break;
			default:
				echo " an error occured. Error code: $error. This should not happen! <br/>";
				break;
		}
	}
}
?>
<?php
mysql_select_db($database, $connection);
//List files from server which is to be shown in table.
$query_Recordset1 = "SELECT id,date,username,filename,extension FROM filestores";
$Recordset1 = mysql_query($query_Recordset1, $connection) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

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
	{$(".selectfile").attr("checked", "checked");
	});$("#dlBTN").click(function()
	{var linkid=$('input#file_ident').val();
	$("#dlBTN").attr("onclick", document.location.href='downloadfiles.php?fileid='+linkid);
});
});</script>

<script type="text/javascript">
	function addRowToBottom(inputElement)
	{
		var givenRow = inputElement.parentNode.parentNode;
		var table = document.getElementById("fileFields");
		var allRows =  table.rows;
		var numRows = allRows.length;
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
</head><body>
<?php
include ("header.php");
?>
<input type="hidden" id="file_ident"/>
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
      <input type="checkbox" name="selectfile2" id="selectfile2" accesskey="2" tabindex="2" value="2" onclick="selected" /></td>
  
   
   
<?php  do { $file=$row_Recordset1['id'];  ?>
    <tr>
     <td><?php echo $file; ?></td><td><?php echo $row_Recordset1['username']; ?></td>
    <td><?php echo $row_Recordset1['date']; ?></td>
    <td><?php echo $row_Recordset1['filename']; ?></td>
    <td><?php echo $row_Recordset1['extension']; ?></td>
    <td><label form="selectfile">Select File</label>
    <input type="checkbox" name="selectfile" class="selectfile" accesskey="2" tabindex="1" onclick="" value="<?php echo $file; ?>" /></td></tr>
    <?php }while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>

<div id="upload">
   <form method="post" action="upload.php" enctype="multipart/form-data">
<!-- <input type="hidden" name="MAX_FILE_SIZE" value="102400" /> not supported by any browsers-->
Input multiple files: <input type="file" multiple="multiple" name="userfile[]" /><br/>
<hr />
<table id="fileFields">
	<tr>
		<td>Input file: </td>
		<td><input type="file" name="userfile[]" onchange="addRowToBottom(this)"/></td>
	</tr>
</table>

<input type="submit" name="submit" value="Submit"/>
</form>
</div></body></html>
<?php
mysql_free_result($Recordset1);
?>