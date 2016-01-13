<?php
include_once("prp_connect.php");
			$MyProjectList=mysql_query("SELECT * FROM filestores");
			echo '<select size="32" name="list" id=id>=1>';
			while ($rows=mysql_fetch_array($MyProjectList))
			{
			$ProName=$rows['filename'];
			echo "<option value=".$rows['id']." selected='selected'>".$ProName."</option>";
			}
			echo '</select>';
?>