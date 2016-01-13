
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
	
	$('#myimg').change(function()
	{
		var filedetails=$('#myimg option:selected').val();
		var imgdesc='filedata.php?idd=' + filedetails;
		 $('#projectinfo').load(imgdesc);
		 
		 
	})
});
</script>

	
		
       

</head>

<body bgcolor="#CCCCCC">
<p>
  <h>
<div align="center" class="Header"><strong>Users Area</strong></div>
<p>


<div class="menu"/>
<ul id="Main_Menu" class="MenuBarHorizontal">
  <li><a class="MenuBarItemSubmenu" href="#">Projects</a>
    <ul>
      <li><a href="#">Deadlines</a></li>
      <li><a href="#">Current Projects</a></li>
      <li><a src="#uploadsys.php">My Projects</a></li>
    </ul></li>
  <li><a class="MenuBarItemSubmenu" href="#"> My Account</a>
  <ul>
    </li>
    <li><a href="#">My Profile</a></li>
    <li><a href="#">My Account Info</a></li>
    <li><a href="#">Logout</a> </li>
  </ul>
</ul>
</div>
</p>
<script type="text/javascript">
var MenuBar1 = new Spry.Widget.MenuBar("Main_Menu", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
    </script>
    
    <div class="MenuBarSubmenuVisible" id="indexcol" >
    <?php
		include "userfiles.php";
		
		
    ?>
    </div>
    
<div id="projectinfo"></div>
</body>
</html>
