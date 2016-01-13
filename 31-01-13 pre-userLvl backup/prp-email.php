<?php

ob_start(); //necessary while we redirect a page
session_start(); //this is required to start session
include('prp_connect.php');
include('prp_functions.php');
check_access(); //check if a session exists


if ($_POST['submit_mail'] == "Send Email") 
{
	$to = $_POST['to_email'][0];
	if ($to == "other")
		$to = $_POST['to_email'][1];
	
	$from = $_POST['mail_from'];
	$subject = $_POST['mail_subject'];
	$message = $_POST['mail_body'];
	
	//mailing system
	
	$header = "From: ".$from;
	if ($_POST['bcc'] == 1) {
		$header .= "\r\nReply-To: ".$from;
	}

	$message_body = $message;
		
	mail($to, $subject, $message_body, $header);
	echo "Mail sent!";
}


?>

<script src="support/jquery-1.7.2.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('#mail_body').attr('value', 'Hi,\n\nThank you\nBest regards\n<?php echo getinfo('name'); ?>\ninfo@pictorep.com\nwww.pictorep.com');
	$("#to_email_dd").change(function() {
		if ( $(this).val() == "other" ) {
			$("#to_email_tx").removeClass("display_none");
		}
		else {
			$("#to_email_tx").addClass("display_none");
		}
	})
});
</script>
<style type="text/css">
 .display_none {display:none}
</style>
<table width="100%" height="auto" border="0" cellspacing="5" cellpadding="0" bgcolor="#e6e4da" >
  <tr>
  <td colspan="2"><?php include('header.php');?></td>
  </tr>
  <tr>
  <td>
  <form id="email_form" method="post">
<table width="63%" border="0" cellspacing="5" cellpadding="0" style="border:groove; border-width:3px">
  <tr>
  	<td width="15%" style='padding:5px; background-color:#FFF;'>To</td>
    <td id="to_email_td">
    <select name="to_email[]" id="to_email_dd">
      <option value=""></option>
      <option value="other" id="other">Other</option>
      <?php 
	  $query = mysql_query("SELECT name, email FROM client_info ORDER BY name") or die(mysql_error());
	  while ($row = mysql_fetch_array($query)) {	  
      	echo "<option value='".$row['email']."'>".$row['name']." (".$row['email'].")</option>";
	  }
	  ?>
      <input type="text" id="to_email_tx" name="to_email[]" class="display_none" />
    </select></td>
  </tr>
  <tr>
  	<td style='padding:5px; border:1px solid lightgray; background-color:#FFF;'>From</td>
    <td><input type="text" id="mail_from" name="mail_from" size="50" readonly value="<?php echo getinfo('email'); ?>" /></td>
    
  </tr>
  <tr>
  	<td style='padding:5px; border:1px solid lightgray; background-color:#FFF;'>Subject</td>
    <td><input type="text" id="mail_subject" name="mail_subject" size="50"/></td>
    
  </tr>
  <tr>
  <td style='padding:5px; border:1px solid lightgray; background-color:#FFF;'>Message</td>
    <td><textarea name="mail_body" id="mail_body" cols="60" rows="8"></textarea></td>
    
  </tr>
  <tr>
    <td></td>
    <td>Bcc Myself <input name="bcc" type="checkbox" id="bcc" value="1"/>
    <input type="submit" id="submit_mail" name="submit_mail" value="Send Email"/></td>
    
  </tr>
</table>
</form>
  </td>
  </tr>
   <tr>
  <td><?php include'footer.php';?></td>
  </tr>
</table>
