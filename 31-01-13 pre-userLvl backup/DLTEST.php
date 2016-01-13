<?php
include_once('prp_connect.php');

$idArr = explode(",", $_GET["fileid"]);
$zippyName = "yourfiles.zip";
// make zip file
$zippy = new ZipArchive();
if($zippy->open($zippyName, ZipArchive::CREATE) !== true)
{
	die("Failed to create zippy!");
}
foreach($idArr as $fileid)
{// for each given file ID
	// get data from database
	$query = "SELECT * FROM filestores WHERE id='$fileid'";
	$result = mysql_query($query);
	$row = mysql_fetch_array($result);
	$fileData = $row['file'];
	$fileName = $row['filename'];
	$fileExtension = $row['extension'];
	// add to the .ZIP
	$zippy->addFromString($fileName.'.'.$fileExtension, $fileData);
	/*echo "added: ".$fileName.'.'.$fileExtension." - data - ";//.$fileData;
	echo "<br/>";*/
}
$zippy->close(); // close zippy, saving changes

// send file to web browser with all information
$zippySize = filesize($zippyName);
//echo "final zippy size: " . $zippySize;
header("Content-Description: File Transfer");
header("Content-type: application/zip");
header("Content-Type: application/force-download");// some browsers need this
header("Content-Disposition: attachment; filename=$zippyName");
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header("Content-Length:". " $zippySize");

ob_clean(); // discard contents of output buffer
flush(); // send everything in write buffer to web browser
readfile("$zippyName"); // read zippy into output buffer

unlink($zippyName); // delete zippy as user now has it
?>