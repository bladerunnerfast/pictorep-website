<?php
include_once('prp_connect.php');
include('prp_functions.php');
check_access(); // redirect if not logged in

// multiple file download V2:
// input of multiple files produce a .ZIP, a single file produces just its self

// inspired from:
// http://tournasdimitrios1.wordpress.com/2012/01/10/compress-zip-multiple-files-and-download-with-php/
$idArr = explode(",", $_GET["fileid"]); // get fileid=1,2,3,4 into array(1,2,3,4)

if(count($idArr) > 1)
{
	$zippyName = "yourfiles.zip";
	// make zip file
	$zippy = new ZipArchive();
	if($zippy->open($zippyName, ZipArchive::CREATE) !== true)
	{
		die("Failed to create zippy!");
	}
	// stores ['fullFileName' => num of occurances]
	// reason for 'fullFileName' as key is file1.JPG and file2.GIF are not the same
	$preExistingFiles = array();
	foreach($idArr as $fileid)
	{// for each given file ID
		// get data from database
		$query = "SELECT * FROM filestores WHERE id='$fileid'";
		$result = mysql_query($query);
		$row = mysql_fetch_array($result);
		$fileData = $row['file'];
		$fileName = $row['filename'];
		$fileExtension = $row['extension'];
		// attempt add to the .ZIP, first check if file already exists
		$fullFileName = $fileName . '.' . $fileExtension;
		if($zippy->statName($fullFileName) !== false )
		{
			if( !array_key_exists($fullFileName, $preExistingFiles) )
			{// 1st re-occurance of file in .ZIP, append (1) index
				$preExistingFiles[$fullFileName] = 1;
				$fileName .= "(copy 1)";
			}else{
				// at least 2nd re-occurance of file in .ZIP, append (i) index
				$preExistingFiles[$fullFileName] += 1;
				$fileName .= '(copy ' . $preExistingFiles[$fullFileName] . ')';
			}
		}
		$zippy->addFromString($fileName.'.'.$fileExtension, $fileData);
	}
	$zippy->close(); // close zippy, saving changes
	// send zip file to web browser with all information
	$zippySize = filesize($zippyName); 
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
}else if(count($idArr) == 1){
	$query = "SELECT * FROM filestores WHERE id='$fileid'";
	$result = mysql_query($query);
	$row = mysql_fetch_array($result);
	$fileData = $row['file'];
	$fileName = $row['filename'];
	$fileExtension = $row['extension'];
	// send file to web browser with all information
	$fileSize = filesize($fileName.'.'.$fileExtension); 
	header("Content-type: image/$fileExtension");
	//header("Content-Type: application/force-download");// causes 'zip' file type in Firefox
	header("Content-Disposition: attachment; filename=\"$fileName.$fileExtension\"");
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');
	header("Content-Length:". " $fileSize");
	// create local copy of file on the server for the readfile() function
	$tempFileHandle = fopen($fileName.'.'.$fileExtension, 'w') or die("Unable to create file");
	fwrite($tempFileHandle, $fileData);
	fclose($tempFileHandle);
	ob_clean(); // discard contents of output buffer
	flush(); // send everything in write buffer to web browser
	readfile($fileName.'.'.$fileExtension); // read file into output buffer
	unlink($fileName.'.'.$fileExtension); // delete temporary file
}

?>