<?php
session_start();
include_once("prp_connect.php");
include_once("prp_functions.php");
$current_user=$_SESSION["username"];
  if(isset($_POST['SubmitFile'])){	
	$date = date('y,n,j');//get current date from server, so it can be stored in db after user has finished uploading.
     //note database stores year,month, day. y=year,n=month,j=day
	  
	 
	 $theblob=addslashes (file_get_contents($_FILES['txt_file']['tmp_name']));
     $myFileName=basename($_POST['txt_fileName']); //Retrieve filename out of file path
	 $tempdata=pathinfo($myFileName,PATHINFO_EXTENSION);//get exstenion name.
	 $tempfile=pathinfo($myFileName,PATHINFO_FILENAME);//get orginal filename.
	connectdb();
	$updateDB=mysql_query("INSERT INTO filestores ( username, date, filename, file, extension ) VALUES('$current_user', '$date','$tempfile','$theblob','$tempdata' )");//add file data and username into database, time needs adding.
			error_reporting(E_ALL);
	echo $myFileName;
	echo "</br>";
	 	echo $tempdata;
		echo "</br>";
		echo $tempfile;
		echo $date;
				
  
  
}
?>


