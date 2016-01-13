<?php
ob_start();
require 'prp_connect.php';
require 'prp_functions.php'; //functions.php has some functions declared that will be necessary in this page
check_access();

if ($_POST['button'] == "Submit Request") {
	$name = $_POST['name'];
	$client_email = $_POST['email'];
	$address = $_POST['address'];
	$country = $_POST['country'];
	$phone = $_POST['phone'];
	$username = $_POST['username'];
	$password = md5($_POST['password']); //md5() function is used for password entryption
	$verifypass = md5($_POST['verify_pass']);
	
	$subject_to_client = "Sign up confirmation";
	$subject_to_vendor = "New staff registration";
	
	// Check if any required field is blank
	if (!$name || !$username || !$address || !$client_email || !$country || !$password || !$verifypass) 
	{
		
		header("Location: ?err_msg=Please fill in all required fields which are marked with an asterisk (*)");
	}
	else {	
	
		     if (preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $client_email) != 1)
		       {
			   
			    header("Location: ?err_msg=Please enter a valid email address");
		       }
			   
		         else 
		           {
					 if($password !== $verifypass)
					 {
						 
						 header("Location: ?err_msg=Passwords must be equal");
					 }
					 	else{
			$result = mysql_query("INSERT INTO client_info(name, email, address, country, phone, username, password) values('$name','$client_email','$address', '$country','$phone','$username','$password')");
			//echo 'Query successfully executed';
		
			
			$vendor_email = "info@pictorep.com";
			$header = "MIME-Version: 1.0" . "\r\n";
			$header .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
		
			$header_for_vendor = $header."From: ".$client_email." <".$vendor_email.">\r\nReply-To: ".$client_email;
			$header_for_client = $header."From: ".$vendor_email." <".$client_email.">\r\nReply-To: ".$vendor_email;
			
			$message_body = "
		<table style='border-collapse:collapse; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px'>
		  <tr>
			<td style='padding:5px; border:1px solid lightgray; background-color:#e3e3e3;'>Name</td>
			<td style='padding:5px; border:1px solid lightgray;'>".$name."</td>
		  </tr>
		  
		  <tr>
		  	<td style='padding:5px; border:1px solid lightgray; background-color:#e3e3e3;'>username</td>
			<td style='padding:5px; border:1px solid lightgray;'>".$username."</td>
		  </tr>
	
		  </tr>
			<td style='padding:5px; border:1px solid lightgray; background-color:#e3e3e3;'>Email</td>
			<td style='padding:5px; border:1px solid lightgray;'>".$client_email."</td>
		  </tr>
		  <tr>
			<td style='padding:5px; border:1px solid lightgray; background-color:#e3e3e3;'>Address</td>
			<td style='padding:5px; border:1px solid lightgray;'>".$address."</td>
		  </tr>
		  <tr>
			<td style='padding:5px; border:1px solid lightgray; background-color:#e3e3e3;'>Phone No.</td>
			<td style='padding:5px; border:1px solid lightgray;'>".$phone."</td>
		  </tr>
		    <tr>
			<td style='padding:5px; border:1px solid lightgray; background-color:#e3e3e3;'>Country</td>
			<td style='padding:5px; border:1px solid lightgray;'>".$country."</td>
		  </tr>
		  
		</table>";
			$message_to_client = "<p>Dear ".$name.",</p><p>This email confirms you that you have successfully finished your registration with Pictorep.com</p><p>Following are the details you submitted on www.pictorep.com:</p>".$message_body."<p>Thank you<br>Best regards<br>Pictorep<br>info@pictorep.com<br>www.pictorep.com</p>";
		
			$message_to_vendor = "<p>Following enquiry has been received:</p>".$message_body;
		
			// Send email to client
			mail($client_email, $subject_to_client, $message_to_client, $header_for_client);
			// Send email to vendor
			mail($vendor_email, $subject_to_vendor, $message_to_vendor, $header_for_vendor);
			
			echo 'Registration process successfully completed!';
		}
	}
}
}
ob_flush();
?>




<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Staff Registration | Pictorep</title>
</head>

<body>

<?php 
if($_GET['err_msg']) 
{ 
echo "<p style='color:red'>".$_GET['err_msg']."</p>";
} 
?>


<table width="100%" border="0" cellspacing="5" cellpadding="0" bgcolor="#e6e4da">

  <tr>
    <td><?php include('header.php');?></td>
  </tr>
  <tr>
    <td>
    
	<!-- Sign Up table starts here-->
  
  <form id="sign-up-form" name="sign-up-form" method="post" action="">
  
  <table width="422" border="0" cellspacing="5" cellpadding="0" style="border:groove; border-width:3px">
  <tr>
  <td colspan="2"><p><em>All fields are required!</em></p></td>
  </tr>
  <tr>
    <td width="142"><label for="name">Name</label></td>
    <td width="265"><input type="text" name="name" id="name" size="34" /></td>
  </tr>
  <tr>
    <td><label for="email">Email</label></td>
    <td width="265"><input type="text" name="email" id="email" size="34" /></td>
  </tr>
  <tr>
    <td><label for="address">Address</label></td>
    <td width="265"><input type="text" name="address" id="address" size="34" /></td>
  </tr>
  <tr>
    <td><label for="country">Country</label></td>
    <td>
    <select id="country" name="country">
    <option selected="selected">Select</option>
    <option>Afghanistan</option>
        <option>Aland Islands</option>
        <option>Albania</option>
        <option>Algeria</option>
        <option>American Samoa</option>
        <option>Andorra</option>
        <option>Angola</option>
        <option>Anguilla</option>
        <option>Antarctica</option>
        <option>Antigua And Barbuda</option>
        <option>Argentina</option>
        <option>Armenia</option>
        <option>Aruba</option>
        <option>Australia</option>
        <option>Austria</option>
        <option>Azerbaijan</option>
        <option>Bahamas</option>
        <option>Bahrain</option>
        <option>Bangladesh</option>
        <option>Barbados</option>
        <option>Belarus</option>
        <option>Belgium</option>
        <option>Belize</option>
        <option>Benin</option>
        <option>Bermuda</option>
        <option>Bhutan</option>
        <option>Bolivia</option>
        <option>Bosnia And Herzegovina</option>
        <option>Botswana</option>
        <option>Bouvet Island</option>
        <option>Brazil</option>
        <option>British Indian Ocean Territory</option>
        <option>Brunei Darussalam</option>
        <option>Bulgaria</option>
        <option>Burkina Faso</option>
        <option>Burundi</option>
        <option>Cambodia</option>
        <option>Cameroon</option>
        <option>Canada</option>
        <option>Cape Verde</option>
        <option>Cayman Islands</option>
        <option>Central African Republic</option>
        <option>Chad</option>
        <option>Chile</option>
        <option>China</option>
        <option>Christmas Island</option>
        <option>Cocos (keeling) Islands</option>
        <option>Colombia</option>
        <option>Comoros</option>
        <option>Congo</option>
        <option>Congo, Democratic Republic</option>
        <option>Cook Islands</option>
        <option>Costa Rica</option>
        <option>Cote D'ivoire</option>
        <option>Croatia</option>
        <option>Cuba</option>
        <option>Cyprus</option>
        <option>Czech Republic</option>
        <option>Denmark</option>
        <option>Djibouti</option>
        <option>Dominica</option>
        <option>Dominican Republic</option>
        <option>Ecuador</option>
        <option>Egypt</option>
        <option>El Salvador</option>
        <option>Equatorial Guinea</option>
        <option>Eritrea</option>
        <option>Estonia</option>
        <option>Ethiopia</option>
        <option>Falkland Islands (malvinas)</option>
        <option>Faroe Islands</option>
        <option>Fiji</option>
        <option>Finland</option>
        <option>France</option>
        <option>French Guiana</option>
        <option>French Polynesia</option>
        <option>French Southern Territories</option>
        <option>Gabon</option>
        <option>Gambia</option>
        <option>Georgia</option>
        <option>Germany</option>
        <option>Ghana</option>
        <option>Gibraltar</option>
        <option>Greece</option>
        <option>Greenland</option>
        <option>Grenada</option>
        <option>Guadeloupe</option>
        <option>Guam</option>
        <option>Guatemala</option>
        <option>Guinea</option>
        <option>Guinea-bissau</option>
        <option>Guyana</option>
        <option>Haiti</option>
        <option>Heard Island/mcdonald Islands</option>
        <option>Holy See (vatican City State)</option>
        <option>Honduras</option>
        <option>Hong Kong</option>
        <option>Hungary</option>
        <option>Iceland</option>
        <option>India</option>
        <option>Indonesia</option>
        <option>Iran</option>
        <option>Iraq</option>
        <option>Ireland</option>
        <option>Israel</option>
        <option>Italy</option>
        <option>Jamaica</option>
        <option>Japan</option>
        <option>Jordan</option>
        <option>Kazakhstan</option>
        <option>Kenya</option>
        <option>Kiribati</option>
        <option>Korea, Democratic Republic</option>
        <option>Korea, Republic Of</option>
        <option>Kuwait</option>
        <option>Kyrgyzstan</option>
        <option>Lao Democratic Republic</option>
        <option>Latvia</option>
        <option>Lebanon</option>
        <option>Lesotho</option>
        <option>Liberia</option>
        <option>Libyan Arab Jamahiriya</option>
        <option>Liechtenstein</option>
        <option>Lithuania</option>
        <option>Luxembourg</option>
        <option>Macao</option>
        <option>Macedonia</option>
        <option>Madagascar</option>
        <option>Malawi</option>
        <option>Malaysia</option>
        <option>Maldives</option>
        <option>Mali</option>
        <option>Malta</option>
        <option>&gt;Marshall Islands</option>
        <option>Martinique</option>
        <option>Mauritania</option>
        <option>Mauritius</option>
        <option>Mayotte</option>
        <option>&gt;Mexico</option>
        <option>Micronesia</option>
        <option>Moldova</option>
        <option>Monaco</option>
        <option>Mongolia</option>
        <option>Montserrat</option>
        <option>Morocco</option>
        <option>Mozambique</option>
        <option>Myanmar</option>
        <option>Namibia</option>
        <option>Nauru</option>
        <option>Nepal</option>
        <option>Netherlands</option>
        <option>Netherlands Antilles</option>
        <option>New Caledonia</option>
        <option>New Zealand</option>
        <option>Nicaragua</option>
        <option>Niger</option>
        <option>Nigeria</option>
        <option>Niue</option>
        <option>Norfolk Island</option>
        <option>Northern Mariana Islands</option>
        <option>Norway</option>
        <option>Oman</option>
        <option>Pakistan</option>
        <option>Palau</option>
        <option>Palestinian Territory</option>
        <option>Panama</option>
        <option>Papua New Guinea</option>
        <option>Paraguay</option>
        <option>Peru</option>
        <option>Philippines</option>
        <option>Pitcairn</option>
        <option>Poland</option>
        <option>Portugal</option>
        <option>Puerto Rico</option>
        <option>Qatar</option>
        <option>Reunion</option>
        <option>Romania</option>
        <option>Russian Federation</option>
        <option>Rwanda</option>
        <option>Saint Helena</option>
        <option>Saint Kitts And Nevis</option>
        <option>Saint Lucia</option>
        <option>Saint Pierre And Miquelon</option>
        <option>Samoa</option>
        <option>San Marino</option>
        <option>Sao Tome And Principe</option>
        <option>Saudi Arabia</option>
        <option>Senegal</option>
        <option>Serbia And Montenegro</option>
        <option>Seychelles</option>
        <option>Sierra Leone</option>
        <option>Singapore</option>
        <option>Slovakia</option>
        <option>Slovenia</option>
        <option>Solomon Islands</option>
        <option>Somalia</option>
        <option>South Africa</option>
        <option>South Georgia/sandwich Isles</option>
        <option>Spain</option>
        <option>Sri Lanka</option>
        <option>St Vincent &amp; The Grenadines</option>
        <option>Sudan</option>
        <option>Suriname</option>
        <option>Svalbard And Jan Mayen</option>
        <option>Swaziland</option>
        <option>Sweden</option>
        <option>Switzerland</option>
        <option>&gt;Syrian Arab Republic</option>
        <option>Taiwan</option>
        <option>Tajikistan</option>
        <option>Tanzania</option>
        <option>Thailand</option>
        <option>Timor-leste</option>
        <option>Togo</option>
        <option>Tokelau</option>
        <option>Tonga</option>
        <option>Trinidad And Tobago</option>
        <option>Tunisia</option>
        <option>Turkey</option>
        <option>Turkmenistan</option>
        <option>Turks And Caicos Islands</option>
        <option>Tuvalu</option>
        <option>Uganda</option>
        <option>Ukraine</option>
        <option>United Arab Emirates</option>
        <option>United Kingdom</option>
        <option>United States</option>
        <option>Uruguay</option>
        <option>Us Minor Outlying Islands</option>
        <option>Uzbekistan</option>
        <option>Vanuatu</option>
        <option>Venezuela</option>
        <option>Viet Nam</option>
        <option>Virgin Islands, British</option>
        <option>Virgin Islands, U.s.</option>
        <option>Wallis And Futuna</option>
        <option>Western Sahara</option>
        <option>Yemen</option>
        <option>Zambia</option>
        <option>Zimbabwe</option>
    </select>
    </td>
  </tr>
  <tr>
    <td><label for="phone">Phone No.</label></td>
    <td width="265"><input type="text" name="phone" id="phone" size="34" /></td>
  </tr>
  <tr>
    <td><label for="username">Username</label></td>
    <td width="265"><input type="text" name="username" id="username" size="34" /></td>
  </tr>
  <tr>
    <td><label for="password">Password</label></td>
    <td width="265"><input type="password" name="password" id="password" size="34" /></td>
  </tr>
  <tr>
    <td><label for="verify_pass">Re-enter password</label></td>
    <td width="265"><input type="password" name="verify_pass" id="verify_pass" size="34" /></td>
  </tr>
  <tr>
    <td><input type="submit" id="button" name="button" value="Submit Request"/></td>
  </tr>
</table>
  </form>

  <!-- Sign Up table finished here-->

    
    </td>
  </tr>
 <tr>
<td><?php include'footer.php';?></td>
</tr>
</table>

</body>
</html>
