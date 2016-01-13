<?php

ob_start(); //necessary while we redirect a page
session_start(); //this is required to start session
include('prp_connect.php');
include('prp_functions.php');
check_pre_login(); //check if someone is already logged in

if($_POST['login'] == "Login") //means if we submit the form, 
{
	if(isset($_POST['username']) && isset($_POST['password'])) //if username and passoword is set
	{
		$username = $_POST['username'];
		$password = $_POST['password'];
		$password_hash = md5($password); //md5() is used for password encryption, it converts the password into a diff. 32 characters number
		
		if(!empty($username) && !empty($password)) //if username and password filed are not empty
		{	
		
			
			$query = "SELECT * FROM client_info WHERE username = '$username' and password = '$password_hash'"; //sending a query into database to bring id matching uname and pass
			if($query_run = mysql_query($query)) //check if the query runs successfully
			{
				$query_num_rows = mysql_num_rows($query_run); //check how many rows has the query been brought
				
				if($query_num_rows == 0) //check if there is no row selected
				{
					echo 'Invalid username/password combination';
				}
				else if ($query_num_rows == 1) //check if there is row selected
				{
					$id = mysql_result($query_run, 0, 'id'); //setting the user id into the variable '$id'
					$username = mysql_result($query_run, 0, 'username'); //setting the user id into the variable '$id'
					$name = mysql_result($query_run, 0, 'name'); //setting the user id into the variable '$id'
					$_SESSION['id'] = $id; //starting a session with the user id
					$_SESSION['username'] = $username; //starting a session with the user id
					$_SESSION['name'] = $name; //starting a session with the user id
					insert_user_log($id);
					header('Location:home.php'); //redirecting the page into 'profile.php'
					exit;
				}
			}
		}
		else
		{
			echo 'You must supply a username and password.';	
		}
	}
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Login | Pictorep | Image Repository</title>
</head>
<body>
<table width="930" border="0" cellspacing="0" cellpadding="0" style="margin:70px auto; text-align:center">
  <tr style="background-image:url(images/background.jpg); background-repeat:no-repeat; width:100%; height:400px">
    <td>
    <form id="form1" name="form1" method="post" action="">
      <table width="auto" border="0" cellspacing="5" cellpadding="0" style="float:right; margin:120px 85px 0 0; text-align:left">
        <tr>
          <td><label for="username">Username</label></td>
          <td>
            <input type="text" name="username" id="username" /></td>
        </tr>
        <tr>
          <td><label for="password">Password</label></td>
          <td><input type="password" name="password" id="password" /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><input type="submit" name="login" id="login" value="Login" /></td>
        </tr>
      </table>
    </form></td>
  </tr>
  <tr>
  	
    <td><p style="margin-bottom:10px; margin-top:3px; padding:0; color:#000; font-size:13px">Developped by PD2 Group 15, Nottingham Trent University, 2012.</p>
  </tr>
 
  <tr>
    <td><img src="images/facebook.png" width="48" height="48" longdesc="http://www.facebook.com" /> <img src="images/google_plus.png" width="48" height="48" alt="Google Plus" /> <img src="images/twitter.png" width="48" height="48" alt="Twitter" /> <img src="images/pinterest.png" width="48" height="48" alt="Pinterest" /> <img src="images/wordpress.png" width="48" height="48" alt="Wordpress" /></td>
  </tr>
   <tr>
  <td><a href="client_registration.php" title="Client Registration">Client Registration</a> | <a href="order_request.php" title="Place New Order">Place New Order</a></td>
  </tr>
</table>
</body>
</html>