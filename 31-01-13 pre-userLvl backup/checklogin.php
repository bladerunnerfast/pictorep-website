
<?php
include_Once("Connect.php");//include DB once as we do not need to use it again.
session_start();//part of the session for username to be stored in their internet cache.
//include("login.htm");
//Create database if not already exsisting.
$dbcreate= "CREATE TABLE IF NOT EXISTS `accounts`(`id` INT, `Username` VARCHAR(20), `Password` TEXT, `Admin` INT, `Email` VARCHAR(40))";
// Retrieve username & Password from Login Form using POST method.
$username=$_POST['username']; 
$password=$_POST['password']; 

// Anti MYSQL Injections, both username and password must be entered ELSE error is returned to client.
$username = stripslashes($username);
$password = stripslashes($password);
$username = mysql_real_escape_string($username);
$password = mysql_real_escape_string($password);
$sql="SELECT * FROM $tableacc WHERE username='$username' and password='$password'";
$result=mysql_query($sql);
$datatest=mysql_num_rows($result);//check if the query returns a row.
//-------------------------------

if($datatest==1)//check if number of rows is 1
{ 
$_SESSION["username"]=$username;//Store username in internet cache.
header("location:upload.htm");//next page after login.
}
else
{
echo "Wrong Username or Password";//inform user has entered incorrect details.
}

?>
