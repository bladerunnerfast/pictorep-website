<?php
include('prp_connect.php');
include('prp_functions.php');
//check_access(); //check if a session exists

if ($_POST['submit'] == "Submit Request") {
	$client = $_POST['client'];
	$company = $_POST['company'];
	$client_email = $_POST['email'];
	$website = $_POST['website'];
	$country = $_POST['country'];
	
	
	$job = $_POST['job'];
	$quotation = $_POST['quotation'];
	$service = $_POST['service'];
	$quantity = $_POST['quantity'];
	$format = $_POST['format'];
	$turnaround = $_POST['turnaround'];
	$message = $_POST['message'];

	
	$subject_to_client = "Request receive confirmation";
	$subject_to_vendor = "New client request";
	
	// Check if any required field is blank
	if (!$client || !$client_email || !$job || !$quotation || !$service) 
	{
		header("Location: ?err_msg=Please fill in all required fields which are marked with an asterisk (*)");
	}
	else {	
		     if (preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $client_email) != 1) //email address validation
		       {
			    header("Location: ?err_msg=Please enter a valid email address"); //error message for ivalid email
		       }
		         else 
		           {
			
			$result = mysql_query("INSERT INTO quote_request(name,company,email,website,country,job,quotation,service,quantity,format,turnaround,message) values('$client','$company','$client_email','$website','$country','$job','$quotation','$service','$quantity','$format','$turnaround','$message')");
			echo 'query complete';
			
			$vendor_email = "info@pictorep.com";
			$header = "MIME-Version: 1.0" . "\r\n";
			$header .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
		
			$header_for_vendor = $header."From: ".$client_email." <".$vendor_email.">\r\nReply-To: ".$client_email;
			$header_for_client = $header."From: ".$vendor_email." <".$client_email.">\r\nReply-To: ".$vendor_email;
			
			$message_body = "
		<table style='border-collapse:collapse; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px'>
		  
		  <tr>
			<td style='padding:5px; border:1px solid lightgray; background-color:#e3e3e3;'>Name</td>
			<td style='padding:5px; border:1px solid lightgray;'>".$client."</td>
		  </tr>
		 
		  <tr>
			<td style='padding:5px; border:1px solid lightgray; background-color:#e3e3e3;'>Company name</td>
			<td style='padding:5px; border:1px solid lightgray;'>".$company."</td>
		  </tr>
		  
		  </tr>
			<td style='padding:5px; border:1px solid lightgray; background-color:#e3e3e3;'>Email</td>
			<td style='padding:5px; border:1px solid lightgray;'>".$client_email."</td>
		  </tr>
		  
		  <tr>
			<td style='padding:5px; border:1px solid lightgray; background-color:#e3e3e3;'>Company website</td>
			<td style='padding:5px; border:1px solid lightgray;'>".$website."</td>
		  </tr>
		  
		  <tr>
			<td style='padding:5px; border:1px solid lightgray; background-color:#e3e3e3;'>Country</td>
			<td style='padding:5px; border:1px solid lightgray;'>".$country."</td>
		  </tr>
		  
		  <tr>
			<td style='padding:5px; border:1px solid lightgray; background-color:#e3e3e3;'>Job name</td>
			<td style='padding:5px; border:1px solid lightgray;'>".$job."</td>
		  </tr>
		  
		    <tr>
			<td style='padding:5px; border:1px solid lightgray; background-color:#e3e3e3;'>Quotation</td>
			<td style='padding:5px; border:1px solid lightgray;'>".$quotation."</td>
		  </tr>
		  
		  <tr>
			<td style='padding:5px; border:1px solid lightgray; background-color:#e3e3e3;'>Service Required</td>
			<td style='padding:5px; border:1px solid lightgray;'>".$service."</td>
		  </tr>
		  
		  <tr>
			<td style='padding:5px; border:1px solid lightgray; background-color:#e3e3e3;'>Quantity</td>
			<td style='padding:5px; border:1px solid lightgray;'>".$quantity."</td>
		  </tr>
		  
		  <tr>
			<td style='padding:5px; border:1px solid lightgray; background-color:#e3e3e3;'>Return image as</td>
			<td style='padding:5px; border:1px solid lightgray;'>".$format."</td>
		  </tr>
		  
		  <tr>
			<td style='padding:5px; border:1px solid lightgray; background-color:#e3e3e3;'>Turnaround</td>
			<td style='padding:5px; border:1px solid lightgray;'>".$turnaround."</td>
		  </tr>
		  
		  <tr>
			<td style='padding:5px; border:1px solid lightgray; background-color:#e3e3e3;'>Instruction/message</td>
			<td style='padding:5px; border:1px solid lightgray;'>".$message."</td>
		  </tr>

		</table>";
			$message_to_client = "<p>Dear ".$name.",</p><p>Thank you for your enquiry. This email confirms that we have received your request. We will look at it and get back to you with an answer shortly.</p><p>Following are the details you submitted on www.pictorep.com:</p>".$message_body."<p>Thank you<br>Best regards<br>Pictorep<br>info@pictorep.com<br>www.pictorep.com</p>";
		
			$message_to_vendor = "<p>Following quotation has been received:</p>".$message_body;
		
			// Send email to client
			mail($client_email, $subject_to_client, $message_to_client, $header_for_client);
			// Send email to vendor
			mail($vendor_email, $subject_to_vendor, $message_to_vendor, $header_for_vendor);
			
			echo 'Request successfully sent!';
			exit;
			
		}
	}
}

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Client Request | Pictorep</title>
</head>
<body bgcolor="#e6e4da">
<table width="100%" border="0" bgcolor="#e6e4da">
  <tr>
    <td height="174">
    
    <table width="33%" border="0" cellspacing="5" cellpadding="0" style="border:groove; border-width:3px">
  	<tr>
  	<td>
  	<h4>Place a new order OR request a quote</h4>
    <p><em>Fields marked with an asterisk (*) are required.</em></p>
<form class="submission box style" id="form1" name="form1" method="post" action="">
  <table width="100%">
    <tr><td style="color:#03F">Personal Details</td></tr>
    <tr>
    
      <td width="112"><label for="client">Name*</label></td>
      <td colspan="2"><input name="client" type="text" id="client" size="40" /></td>
    </tr>
    <tr>
      <td><label for="company">Company*</label></td>
      <td colspan="2"><input name="company" type="text" id="company" size="40" /></td>
    </tr>
    <tr>
      <td><label for="email">Email*</label></td>
      <td colspan="2"><input name="email" type="text" id="email" size="40" /></td>
    </tr>
    <tr>
      <td><label for="website">Website</label></td>
      <td colspan="2"><input name="website" type="text" id="website" size="40" /></td>
    </tr>
    <tr>
      <td><label for="country">Country*</label></td>
      <td colspan="2">
      	<select name="country" id="country">
        <option value="" selected="selected">Select</option>
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
        <option>Syrian Arab Republic</option>
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
    <td style="color:#03F">Job Details</td>
    </tr>
    <tr>
    
      <td width="112"><label for="job">Job name</label></td>
      <td colspan="2"><input name="job" type="text" id="job" size="40" /></td>
    </tr>
    <tr>
    	<td><label for="quotation">Quotation*</label></td>
       
        <td colspan="2">
        <select id="quotation" name="quotation">
        <option value="" selected="selected">Select</option>
        <option>New order</option>
        <option>Quotation request</option>
        </select>
        </td>
    </tr>
    
    
    <tr>
    	<td><label for="service">Service required</label></td>
       
        <td colspan="2">
        
        <select id="service" name="service">
        <option value="" selected="selected">Select</option>
        <option>Photography service</option>
        <option >Image editing service</option>
        <option>Both Photography & Image editing service </option>
        </select>
        </td>
    </tr>
    <tr>
    	<td><label for="quantity">Quantity</label></td>
        <td><input type="quantity" id="quantity" name="quantity" /></td>
    </tr>
    <tr>
    	<td><label for="format">Retun as*</label></td>
        <td>
        <select id="format" name="format">
        <option value="" id="selected" selected="selected">Select</option>
        <option>JPEG</option>
        <option>PNG</option>
        <option>PSD</option>
        <option>TIFF</option>
        <option>AI</option>
        <option>EPS</option>
        <option>PDF</option>
        <option>Other</option>
        </select>
        </td>
    </tr>
    <tr>
    <td><label for="turnaround">Turnaround</label></td>
    <td colspan="2">
    <select id="turnaround" name="turnaround">
    	<option value="" selected="selected">Select</option>
    	<option>7 days</option>
        <option>14 days</option>
        <option>1 month</option>
        <option>Flexible</option>
        <option>Others</option>
    </select>
    
    </td>
    </tr>
    <tr>
    	<td><label for="message">Instruction/message</label></td>
        <td><textarea name="message" id="message" cols="35" rows="8"></textarea></td>
    </tr>
    <tr>
      <td colspan="2"><input type="submit" name="submit" id="submit" value="Submit Request" style="float:left; margin-left:210px; margin-top:10px"/></td>
    </tr>
  </table>
</form>
    

    </td>
	</tr>
	</table>
    
    
    
    </td>
	</tr>
</table>
</body>
</html>