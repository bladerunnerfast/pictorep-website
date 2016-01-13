<?php require_once('Connections/test1.php'); ?>
<?php


include('prp_functions.php');
check_access();

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
}
}

mysql_select_db($database_test1, $test1);
$query_Recordset1 = "SELECT id,date,username,filename,extension FROM filestores";
$Recordset1 = mysql_query($query_Recordset1, $test1) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

function download()
{


$query="SELECT * FROM filestores WHERE id=49";
$result=mysql_query($query);
$row=mysql_fetch_array($result);
$file=$row['file'];
$filename=$row['filename'];
$type=$row['extension'];

header("Content-type: $type");
//header("Content-Disposition: attachment; filename=$filename");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Download Area</title>
<script src="www/jquery.js"> </script>
<script type="text/javascript">

$(document).ready(function()
{
	$('input[type=checkbox]').change(function()
	{
		var fileid=$('input[type=checkbox]:checked').val();
		$('input#file_ident').val(fileid);
	});
	
	$("#selectfile2").change(function()
	{
		$(".selectfile").attr("checked", "checked"); 
	
	});                     
	                          
	$("#dlBTN").click(function()
	{
	
	var linkid=$('input#file_ident').val();
	$("#dlBTN").attr("onclick", document.location.href='downloadfiles.php?fileid='+linkid);
});
});


</script>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php
include ("header.php");
?>
<input type="hidden" id="file_ident"/></td>
<table class="DLList">
  <tr>
  
    <td width="50">id</td>
    <td width="146">username</td>
    <td width="80">date</td>
    <td width="138">filename</td>
    <td width="50">extension</td>
    <td width="130"><INPUT TYPE="BUTTON" id="dlBTN" VALUE="Download"/></td>
  </tr>
  <tr>
   <td width="50"><input type"text" id="txt1"/></td>
    <td width="146"><input type"text" id="txt2"/></td>
    <td width="80"><input type"text" id="txt3"/></td>
    <td width="138"><input type"text" id="txt4"/></td>
    <td width="50"><input type"text" id="txt5"/></td>
  	<td width="130">Select All&nbsp&nbsp;                       
      <input type="checkbox" name="selectfile2" id="selectfile2" accesskey="2" tabindex="2" value="2" onclick="selected" /></td>
  </tr>
  <?php do { $file=$row_Recordset1['id'];?>
    <tr>
     <td><?php echo $file; ?></td>
    <td><?php echo $row_Recordset1['username']; ?></td>
    <td><?php echo $row_Recordset1['date']; ?></td>
    <td><?php echo $row_Recordset1['filename']; ?></td>
    <td><?php echo $row_Recordset1['extension']; ?></td>
    <td><label form="selectfile">Select File</label>
    <input type="checkbox" name="selectfile" class="selectfile" accesskey="2" tabindex="1" onclick="" value="<?php echo $file; ?>">
</td>
    </tr>
    <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>