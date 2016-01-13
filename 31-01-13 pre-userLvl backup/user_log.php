<?php
ob_start(); //necessary while we redirect a page
session_start(); //this is required to start session
include('prp_connect.php');
include('prp_functions.php');
check_access();

	$http_client_ip = $_SERVER['HTTP_CLIENT_IP'];
	$http_x_forwarded_for = $_SERVER['HTTP_X_FORWARDED_FOR'];
	$remote_addr = $_SERVER['REMOTE_ADDR'];

	if(!empty($http_client_ip))
	{
	$ip_address = $http_client_ip;
	}
	else if(!empty($http_x_forwarded_for))
	{
	$ip_address = $http_x_forwarded_for;
	}
	else
	{
	$ip_address = $remote_addr;
	}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Pictorep | User Log</title>
<link rel="stylesheet" type="text/css" href="style.css"/>

<!--Javascrip code started here-->

<script type="text/javascript">
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
</script>
<link rel="stylesheet" type="text/css" href="support/jquery-ui-1.9.1.custom.min.css" />
<link rel="stylesheet" type="text/css" href="support/ui.jqgrid.css" /> <!--This file is required for theme setup-->

<script src="support/jquery-1.7.2.min.js" type="text/javascript"></script>
<script src="support/jquery-ui-1.9.1.custom.min.js" type="text/javascript"></script>
<script src="support/grid.locale-en.js" type="text/javascript"></script>
<script src="support/jquery.jqGrid.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
	var mygrid = jQuery("#user_log").jqGrid({
		url:"user_log_search.php?q=1",
		datatype: "json",
		autowidth: true,
		height: 580,
		colNames:['ID', 'User ID','Username','Login Time','Logout Time','IP Address', 'IP Location'],
		colModel:
		[
			{name:'id',index:'id',search:false},
			{name:'user_id',index:'user_id',search:false}, //to turn on search option
			{name:'username',index:'username',search:true},
			{name:'login_time',index:'login_time',search:false}, //to make it editable "editable:true"
			{name:'logout_time',index:'logout_time',search:false},
			{name:'ip_address',index:'ip_address',search:false},
			{name:'ip_location',index:'ip_location',search:false}
		],
		rowNum:25,
		mtype: "POST",
		rowList:[25,50,100],
		pager: '#user_log_pager',
		sortname: 'id',
		sortorder: "asc",
		viewrecords: true,
		rownumbers: true,
		gridview : true,
		footerrow : true,
		ExpandColClick : true,
		editurl: "user_log_edit.php",
		hidegrid:false,
		//toppager:true,
		caption:"", //this appears just above the columns name whatever string put inside of it
		cellLayout:2,
		altRows:true,

		loadError : function(xhr,st,err) {
			jQuery("#user_log").html("Type: "+st+"; Response: "+ xhr.status + " "+xhr.statusText);
		}
	});
	
	jQuery("#user_log").jqGrid('navGrid','#user_log_pager',
	{edit:true,add:true,del:true,search:false,refresh:true,view:true},
	{height:'auto',width:'auto',reloadAfterSubmit:true, closeAfterEdit:true, closeOnEscape:true,savekey:[true,13]}, // edit options
	{height:'auto',width:'auto',reloadAfterSubmit:true, closeAfterAdd:true, closeOnEscape:true,savekey:[true,13]}, // add options
	{reloadAfterSubmit:false} // del options
	);
	jQuery("#user_log").filterToolbar({searchOnEnter:false});
});
</script>

<!--Javascrip code ended here-->

</head>
<body>

<table id="main_menu" width="100%" border="0" align="center" bgcolor="#e6e4da">
  <tr>
    <td><?php include 'header.php';?></td>
  </tr>
  
  <tr>
    <table id="user_log"></table>
	<div id="user_log_pager"></div>
    
  </tr>
   <tr>
  <td><?php include'footer.php';?></td>
  </tr>

</table>

	
</body>

</html>