<?php
	include_once("prp_connect.php");
	include('prp_functions.php');
			$descs = $_GET["id"];
			$projectlist=mysql_query("SELECT * FROM filestores WHERE id='".$descs."'");
			$row_files = mysql_fetch_assoc($projectlist);
			$totalRows = mysql_num_rows($projectlist);
			$data=$row_files['id'];
			$filename=$row_files['filename'];
			$extension=$row_files['extension'];
			$date=$row_files['date'];
			$usersubmitted=$row_files['username'];
			//$time=$row_files['time'];
			
			
		echo "Filename:-  $filename.$extension" ;
		echo "</br>";
		echo "Date:- submitted $date";
		echo "</br>";
		echo "User of submission:- $usersubmitted";
		echo "</br>";
		echo "</br>";
		echo "<img src='imgview.php?id=$data' width='150' height='150'/>";
		echo "</br>";
		echo "<a href='imgview.php?id=$data'>View original Size</a>";
		echo '<form onSubmit="imgdownload()">';
		echo '</form>';
		
		
		
		?>