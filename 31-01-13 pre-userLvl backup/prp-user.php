<?php
ob_start(); //necessary while we redirect a page
session_start(); //this is required to start session
include('prp_connect.php');
include('prp_functions.php');
check_access(); //check if a session exists

	$Name = getfield('name');
	$Email = getfield('email');
	$Address = getfield('address');
	$Country = getfield('country');
	$Phone = getfield('phone');
	
	$http_client_ip = $_SERVER['HTTP_CLIENT_IP'];
	$http_x_forwarded_for = $_SERVER['HTTP_X_FORWARDED_FOR'];
	$remote_addr = $_SERVER['REMOTE_ADDR'];

	
	if(!empty($http_client_ip))
	{
	$ip_address = $http_client_ip;
	}
	else if(!empty($http_x_forwarded_for))
	{
	$ip_address = $http_x_forwarded_for;
	}
	else
	{
	$ip_address = $remote_addr;
	}
?>
<table width="100%" border="0" bgcolor="#e6e4da">
  <tr>
    <td scope="col"><?php include('header.php')?></td>
  </tr>
  <tr>
  
  <td>This page is under construction! Your ID address is: <?php echo $ip_address;?></td>
  
  </tr>
</table>