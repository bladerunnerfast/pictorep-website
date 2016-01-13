<?php
ob_start(); //necessary while we redirect a page
if( !isset($_SESSION) ) 
{ 
	session_start(); 
}
include('prp_connect.php');

check_access(); //check if a session exists
function getname()
{
	$query=  mysql_query("SELECT name FROM client_info WHERE id = '".$_SESSION['id']."'");
	$row = mysql_fetch_array($query);
	return $row['name'];
}

?>
<style type="text/css">

#menu a:link {color:#1B1B1B; text-decoration:none}      /* unvisited link */
#menu a:visited {color:#1B1B1B; text-decoration:none}  /* visited link */
#menu a:hover {color:#090; text-decoration:none}  /* mouse over link */
#menu a:active {color:#0000FF; text-decoration:none}  /* selected link */
#menu
{
	font-family:Arial, Helvetica, sans-serif;
	font-size:12px;
}
</style>

<table id="menu" width="100%" border="0" bgcolor="#C6C6C6">
  <tr>
    <th width="8%" height="26" bgcolor="#e6e4da" scope="col"><a href="home.php">Home</a></th>
    <th width="11%" bgcolor="#e6e4da" scope="col"><a href="Filetransfer.php">Upload-Download</a></th>
    <th width="12%" bgcolor="#e6e4da" scope="col"><a href="prp-preview.php">Preview</a></th>
    <th width="7%" bgcolor="#e6e4da" scope="col"><a href="staff.php">Staff</a></th>
    <th width="10%" bgcolor="#e6e4da" scope="col"><a href="client.php">Client</a></th>
    <th width="11%" bgcolor="#e6e4da" scope="col"><a href="prp-messaging.php">Messaging</a></th>
    <th width="15%" bgcolor="#e6e4da" scope="col"><a href="prp-my-account.php">My Account</a></th>
    <th width="26%" bgcolor="#e6e4da" scope="col">If you are not <span style="font-size:12px; color:#00F"><?php echo getname();?></span><a href="prp_sign_out.php"> Logout</a></th>
    
  </tr>
</table>
