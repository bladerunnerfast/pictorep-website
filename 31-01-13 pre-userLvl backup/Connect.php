<?php

//-------------MYSQL Connection
//access to database table.
$host="localhost"; // Host name 
$usr="root"; // Mysql username 
$pass=""; // Mysql password 
$dbName="pictorep_client"; // Database name
$tableacc="client_info"; // Table name 
$filetable="filestores";//database table for uploaded files.

//connect to database and make sure connection is established.
mysql_connect("$host", "$usr", "$pass")or die("cannot connect"); 
mysql_select_db("$dbName")or die("cannot access the database");

?>