<?php
session_start();
//Insertion of logout time into the user_log table
$logout_time = date("Y-m-d H:i:s");
$id = $_SESSION['id'];
include('prp_connect.php');
mysql_query("UPDATE user_log SET logout_time = '$logout_time' WHERE user_id= '$id' AND logout_time = '0000-00-00 00:00:00'");
session_destroy();
header("Location: index.php");
exit;
?>