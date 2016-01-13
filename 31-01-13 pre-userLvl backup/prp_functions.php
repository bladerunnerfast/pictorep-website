<?php
if( !isset($_SESSION) ) 
{ 
	session_start(); 
}
ob_start();
include('prp_connect.php');

$current_file = $_SERVER['SCRIPT_NAME'];


function loggedin()
{
	if(isset($_SESSION['id']) && !empty($_SESSION['id']))
	{
		return true;
	}
	else 
	{
		return false;
	}
}
//this function can return session id, uname and name
function getfield($field)
{
	return $_SESSION[$field];
}

//this function provides access restriction to a page 
function check_access() {
	if (!$_SESSION['id']) {
		header("Location: index.php");
		exit;	
	}
}

//this function checks if a session already exists
function check_pre_login() {
	if ($_SESSION['id']) {
		header("Location: home.php");
		exit;	
	}
}

//this function is used to insert user login data
function insert_user_log($user_id){
	
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
	
	$login_time = date("Y-m-d H:i:s"); //grabs the current time as login time
	$username = $_SESSION['username'];
	$ip_location = 'internal';

	mysql_query("INSERT INTO user_log(user_id, username, login_time, ip_address, ip_location) values ('$user_id', '$username', '$login_time','$ip_address','internal')");
	
}

//this function can return whatever data is passed as parameter when called
function getinfo($data)
{
	$query = mysql_query("SELECT * FROM client_info WHERE id = '".$_SESSION['id']."'");
	$row = mysql_fetch_array($query);
	return $row[$data];
}


?>