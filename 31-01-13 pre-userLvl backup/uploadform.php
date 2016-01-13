<?php
include('prp_functions.php');
check_access();
include_once("prp_connect.php");

$current_user=$_SESSION['username'];
  if(isset($_POST['SubmitFiles'])){	
	$date = date('y,n,j');//get current date from server, so it can be stored in db after user has finished uploading.
     //note database stores year,month, day. y=year,n=month,j=day
	 $theblob=addslashes (file_get_contents($_FILES['imgfile']['tmp_name']));
     $myFileName=basename($_POST['fileN']); //Retrieve filename out of file path
	 $tempdata=pathinfo($myFileName,PATHINFO_EXTENSION);//get exstenion name.
	 $tempfile=pathinfo($myFileName,PATHINFO_FILENAME);//get orginal filename
	
	$updateDB=mysql_query("INSERT INTO filestores ( username, date, filename, file, extension ) VALUES('$current_user', '$date','$tempfile','$theblob','$tempdata' )");//add file data and username into database, time needs adding.
			error_reporting(E_ALL);
	 
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Upload form</title>
<script type="text/javascript" src="jquery.js"></script>
</head>

<body>

 
  <script type="text/javascript">
  $(document).ready(function(){
 function Addrows(filelist){
 var newrrow =$('<tr><td>fuck</td></tr>');
	  $('#filelist').append(newrow);
	  }});
	  </script>.
      <table id="filelist" border="1">
  <tr>
    
    <td width="284"><div align="left">Please select your files</div></td>
    <td width="154">Upload Selection</td>
  </tr>
    <tr>
      
      <td> 
        <div align="right">
        <form enctype="multipart/form-data" action="" method="POST">
          <input name="imgfile" type="file" mmultiple="multiple"  id="imgfile" tabindex="1" size="35" value="imgfile" onchange="fileN.value=imgfile.value" />
          <input name="fileN" type="hidden" id="fileN" tabindex="99" value="fileN" size="1" />
      </div></td>
      
      
      <td> Add more<div align="right">
        <input type="checkbox" name="selected" value="checkbox" id="selected" onclick="Addrows('filelist')" />
        
        <input type="submit" name="SubmitFiles" value="Upload File" accesskey="ENTER" tabindex="1" />
      </div></td>
    </tr>
    
</table>

</form>
</body>
</html>
<!--added required functions (uploading system)-->

