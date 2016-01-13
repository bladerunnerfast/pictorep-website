<?php
ob_start(); //necessary while we redirect a page
session_start(); //this is required to start session
include('prp_connect.php');
include('prp_functions.php');
check_access(); //check if a session exists

function getdata($info)
{
	$query = mysql_query("SELECT * FROM client_info WHERE id = '".$_SESSION['id']."'");
	$row = mysql_fetch_array($query);
	return $row[$info];
}
	
	
	$name = $_POST['name'];
	$email = $_POST['email'];
	$address = $_POST['address'];
	$country = $_POST['country'];
	$phone = $_POST['phone'];
	$newpassword = $_POST['newpassword'];
	$changepassword = $_POST['changepassword'];
	
	$newpassword_hash = md5($_POST['newpassword']);
	
if($_POST['submit'] == 'Update Profile')
{
	
	if((!empty($newpassword) && !empty($changepassword)) && ($newpassword == $changepassword))
	{
		mysql_query("UPDATE client_info SET name = '$name', email = '$email', address = '$address', country = '$country', phone = '$phone', password = '$newpassword_hash' WHERE id = '".$_SESSION['id']."'");
		echo 'Profile information have been updated!';
	}else if(empty($newpassword) || empty($changepassword))
	{
		mysql_query("UPDATE client_info SET name = '$name', email = '$email', address = '$address', country = '$country', phone = '$phone' WHERE id = '".$_SESSION['id']."'");
		echo 'Profile information have been updated without password!';
	}

}
	

?>

<table width="100%" border="0" bgcolor="#e6e4da">
  <tr>
    <td scope="col"><?php include('header.php')?></td>
  </tr>
  <tr>
    <td height="174">
    <form action="" method="post" name="profile">
    <table width="39%" border="0" cellspacing="5" cellpadding="0" style="border:groove; border-width:3px">
  <td colspan="2" width="41%"><p style="font-size:16px">Welcome <?php echo getdata('name');?></p></td>
  <tr>
  	<td style='padding:5px; border:1px solid lightgray; background-color:#FFF;'>Name</td>
    <td width="59%" style='padding:5px; border:1px solid lightgray; background-color:#FFF'><input type="text" name="name" id="name" size="40" value="<?php echo getdata('name');?>"/></td>
  </tr>
  <tr>
    <td style='padding:5px; border:1px solid lightgray; background-color:#FFF;'>Email</td>
    <td style='padding:5px; border:1px solid lightgray; background-color:#FFF'><input type="text" name="email" id="email" size="40" value="<?php echo getdata('email');?>"/></td>
  </tr>
  <tr>
    <td style='padding:5px; border:1px solid lightgray; background-color:#FFF;'>Address</td>
    <td style='padding:5px; border:1px solid lightgray; background-color:#FFF'><input type="text" name="address" id="address" size="40" value="<?php echo getdata('address');?>"/></td>
  </tr>
  <tr>
    <td style='padding:5px; border:1px solid lightgray; background-color:#FFF;'>Country</td>
    <td style='padding:5px; border:1px solid lightgray; background-color:#FFF'><input type="text" name="country" id="country" size="40" value="<?php echo getdata('country');?>"/></td>
  </tr>
  <tr>
    <td style='padding:5px; border:1px solid lightgray; background-color:#FFF;'>Phone</td>
    <td style='padding:5px; border:1px solid lightgray; background-color:#FFF'><input type="text" name="phone" id="phone" size="40" value="<?php echo getdata('phone');?>"/></td>
  </tr>
  <tr>
  <td style="color:#33F">Change Password</td>
  </tr>
  <tr>
    <td style='padding:5px; border:1px solid lightgray; background-color:#FFF;'><label for="newpassword">New Password</label></td>
    <td style='padding:5px; border:1px solid lightgray; background-color:#FFF'><input type="password" name="newpassword" id="newpassword" size="40"/></td>
  </tr>
  <tr>
    <td style='padding:5px; border:1px solid lightgray; background-color:#FFF;'><label for="changepassword">Confirm New password</label></td>
    <td style='padding:5px; border:1px solid lightgray; background-color:#FFF'><input type="password" name="changepassword" id="changepassword" size="40"/></td>
  </tr>
  <tr>
  <td align="center"><input type="submit" name="submit" id="submit" value="Update Profile"/></td>
  </tr>

</table>
</form>    
    
    
    </td>
	</tr>
     <tr>
  <td><?php include'footer.php';?></td>
  </tr>
</table>