<?php

require_once("prp_connect.php");
include('prp_functions.php');
$r_ID = $_GET['id'];
$rec_view = mysql_query("SELECT * FROM filestores WHERE id=$r_ID");
$rec_count=mysql_num_rows($rec_view );

while($row_view = mysql_fetch_assoc($rec_view))
{
header('Content-Type: image/jpeg');
echo $row_view['file'];
}
?>