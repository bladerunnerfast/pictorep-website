<?php
	
$host = "localhost";
$database = "pictorep_client";
$username = "pictorep";
$password = "HOIp3RH81HnN";
	mysql_connect($host, $username, $password) or die("Unable to connect database"); //connecting to the database (ip, uname, pass)
	$connection = mysql_pconnect($host, $username, $password) or trigger_error(mysql_error(),E_USER_ERROR);
	mysql_select_db("pictorep_client") or die("Unable to select database"); //selecting a database
	
?>