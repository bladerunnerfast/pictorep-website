
<!--Created using dreamweavers functions-->
<?php
include_once("prp_connect.php");
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$maxRows_Uploadsys = 0;
$pageNum_Uploadsys = 0;
if (isset($_GET['pageNum_Uploadsys'])) {
  $pageNum_Uploadsys = $_GET['pageNum_Uploadsys'];
}
$startRow_Uploadsys = $pageNum_Uploadsys * $maxRows_Uploadsys;


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Upload form</title>
</head>

<body>

  <?php do { ?>
  <script type="text/javascript">
  function addrow(){
	  if (document.forms[0].checbox.checked){
		  
		  var newrows=new Array();
		  
	  }
	  }
	  </script>
      <table id="filelist" border="1">
  <tr>
    
    <td width="284"><div align="left">Please select your files</div></td>
    <td width="154">Upload Selection</td>
  </tr>
    <tr>
      
      <td> 
        <div align="right">
        <form enctype="multipart/form-data" action="" method="POST">
          <input name="imgfile" type="file" id="imgfile" tabindex="1" size="35" onchange="imgfileN[].value=imgfile.value" />
          <input name="fileN[]" type="hidden" id="fileN[]" tabindex="99" size="1" />
      </div></td>
      
      
      <td> Add more<div align="right">
        <input type="checkbox" name="selected" value="checkbox" id="selected" />
        
        <input type="submit" name="SubmitFiles" value="Upload File" accesskey="ENTER" tabindex="1" />
      </div></td>
    </tr>
    <?php } while ($checkbox=1) ?>
</table>

</form>
</body>
</html>
<!--added required functions (uploading system)-->
<?php
$current_user=$_SESSION["username"];
  if(isset($_POST['SubmitFiles'])){	
	$date = date('y,n,j');//get current date from server, so it can be stored in db after user has finished uploading.
     //note database stores year,month, day. y=year,n=month,j=day
	 $theblob=addslashes (file_get_contents($_FILES['imgfile']['tmp_name']));
     $myFileName=basename($_POST['imgfileN[]']); //Retrieve filename out of file path
	 $tempdata=pathinfo($myFileName,PATHINFO_EXTENSION);//get exstenion name.
	 $tempfile=pathinfo($myFileName,PATHINFO_FILENAME);//get orginal filename.
	connectdb();
	$updateDB=mysql_query("INSERT INTO filestores ( username, date, filename, file, extension ) VALUES('username', '$date','$tempfile','$theblob','$tempdata' )");//add file data and username into database, time needs adding.
			error_reporting(E_ALL);
	
}
?>

<?php
echo "<mm:dwdrfml documentRoot=" . __FILE__ .">";$included_files = get_included_files();foreach ($included_files as $filename) { echo "<mm:IncludeFile path=" . $filename . " />"; } echo "</mm:dwdrfml>";
?>