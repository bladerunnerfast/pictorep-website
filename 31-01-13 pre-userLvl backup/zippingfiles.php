<?php
include_once('prp_connect.php');

$fileIdValues = explode(",", $_GET["fileid"]);
$zipname= "yourfiles.zip";
$zippysize = filesize($zipname); 
// create .zip file, check if open and die if not
$zippy = new ZipArchive(); 
if ($zippy->open($zipname, ZIPARCHIVE::CREATE ) !== TRUE)
{
	exit("Error during process, contact administrator!!");  
}
foreach($fileIdValues as $fileid)
{// for every file
	$query="SELECT * FROM filestores WHERE id='$fileid'";
	$result=mysql_query($query);
	$row=mysql_fetch_array($result);
	$file=$row['file'];
	$filename=$row['filename'];
	$type=$row['extension'];
	
	// make temporary, combined from 3 database bits
	
	//zipping files, still requires work.
	$zippy->addFromString($filename.'.'.$type, $file);
	
	// remove temporary file
	
	
	
}
// IMPORTANT: No output of any kind can be given by this script before header() calls
// doing so results in the "headers already sent" error
//headers adding my James, at present single file can be downloaded on both IE and GG browsers.
$zippy->close();
header('Content-Description: File Transfer');
header("Content-type: application/zip"); 
header("Content-Disposition: attachment; filename=$zipname"); 
header("Content-Length:". " $zippysize"); 
header('Content-Transfer-Encoding: binary');
header('Cache-Control: must-revalidate');
readfile("$zipname");
ob_clean();
flush();
unlink("$zipname");


?>