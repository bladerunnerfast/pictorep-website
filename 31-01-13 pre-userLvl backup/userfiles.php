<?php

include_once("Connect.php");

			//function myprojectlist ($select)
			//{
			$name = $_GET["name"];
			$MyFileList=mysql_query("SELECT * FROM uploaded WHERE username='".$name."' ORDER BY filename AND date AND time");
			echo '<select size="32"  id="myimg">';
			while ($frows=mysql_fetch_array($MyFileList))
			{
			$FileN=$frows['filename'];
			$date=$frows['date'];
			
			echo "<option value=".$frows['id']." selected='selected'>".$FileN." ".$date."</option>";
			
			}
			echo '</select>';
			//}
echo "<script type='text/javascript'>",
"$(document).ready(function()",
"{",	
	
	"$('#myimg').change(function()",
	"{",
		"var filedetails=$('#myimg option:selected').val();",
		"var imgdesc='filedata.php?idd=' + filedetails;",
		" $('#projectinfo').load(imgdesc);",
		 
		 
	"});",
"});",
"</script>"

?>