<?php
// Local
	/*$mysql_host = 'localhost';
	$mysql_user = 'root';
	$mysql_pass = 'root';
	$mysql_db = 'pictorep';*/
// Remote
	$mysql_host = 'localhost';
	$mysql_user = 'pictorep';
	$mysql_pass = 'HOIp3RH81HnN';
	$mysql_db = 'pictorep_client';
	
if(!mysql_connect($mysql_host, $mysql_user, $mysql_pass) || !mysql_select_db($mysql_db))
{
		echo 'Unable to connect to the database';
}
?>