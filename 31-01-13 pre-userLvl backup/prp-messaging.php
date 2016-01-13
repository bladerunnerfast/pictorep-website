<?php
ob_start(); //necessary while we redirect a page
session_start(); //this is required to start session
include('prp_connect.php');
include('prp_functions.php');
check_access(); //check if a session exists


?>
<title>Messaging | Pictorep</title>

<table width="100%" border="0" bgcolor="#e6e4da">
  <tr>
    <td scope="col"><?php include('header.php')?></td>
  </tr>
  <tr>
    <td height="174">
    <table width="33%" border="0" cellspacing="5" cellpadding="0" style="border:groove; border-width:5px">
  <td>Pictorep Messaging</td>
  <tr>
  	<td><h3>Coming Soon!</h3></td>

  </tr>
  

</table>
    
    
    
    </td>
	</tr>
    <tr>
  <td><?php include'footer.php';?></td>
  </tr>
</table>