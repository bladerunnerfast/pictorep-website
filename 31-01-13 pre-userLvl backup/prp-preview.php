<?php
ob_start(); //necessary while we redirect a page
session_start(); //this is required to start session
include('prp_connect.php');
include('prp_functions.php');
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>User Area</title>

<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="jquery.js"></script>
<style type="text/css">
h1 {
	font-size: 18px;
	color: #F0F0F0;
}

</style>
	<script type="text/javascript">
	$(document).ready(function()
{
	$('#indexcol').change(function()
	{
		var proglist=$("#indexcol option:selected").val();
		var imglist='filedata.php?id='+ proglist;
		 $("#projectinfo").load(imglist);
		 
	});
});
</script></head>

<body>
<?php
include ("header.php");
?>
<p>
  <h>
<div align="center" class="Header"><strong>PreView Area</strong></div>

<script type="text/javascript">
var MenuBar1 = new Spry.Widget.MenuBar("Main_Menu", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
    </script>
    
<div class="MenuBarSubmenuVisible" id="indexcol" >
  <?php
		include "uploadsys.php";
		
		
    ?>
    </div>
<div id="projectinfo"></div>
</body>
</html>
