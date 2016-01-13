<?php

include('prp_functions.php');
check_access();


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Pictorep | Client</title>
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
	var mygrid = jQuery("#client").jqGrid({
		url:"client_search.php?q=1",
		datatype: "json",
		autowidth: true,
		height: 580,
		colNames:['ID', 'Name','Company','Email','Website','Address','Country','Phone'],
		colModel:
		[
			{name:'id',index:'id',search:false},
			{name:'name',index:'name',search:true}, //to turn on search option
			{name:'company',index:'company',search:true}, //to turn on search option
			{name:'email',index:'email',search:true}, //to make it editable "editable:true"
			{name:'website',index:'website',search:false},
			{name:'address',index:'address',search:false},
			{name:'country',index:'country',search:false},
			{name:'phone',index:'phone',search:false}
		],
		rowNum:25,
		mtype: "POST",
		rowList:[25,50,100],
		pager: '#client_pager',
		sortname: 'id',
		sortorder: "asc",
		viewrecords: true,
		rownumbers: true,
		gridview : true,
		footerrow : true,
		ExpandColClick : true,
		editurl: "client_edit.php",
		hidegrid:false,
		//toppager:true,
		//caption:"Client details", //this appears just above the columns name whatever string put inside of it
		cellLayout:2,
		//altRows:true,

		loadError : function(xhr,st,err) {
			jQuery("#client").html("Type: "+st+"; Response: "+ xhr.status + " "+xhr.statusText);
		}
	});
	
	jQuery("#client").jqGrid('navGrid','#client_pager',
	{edit:true,add:true,del:true,search:false,refresh:true,view:true},
	{height:'auto',width:'auto',reloadAfterSubmit:true, closeAfterEdit:true, closeOnEscape:true,savekey:[true,13]}, // edit options
	{height:'auto',width:'auto',reloadAfterSubmit:true, closeAfterAdd:true, closeOnEscape:true,savekey:[true,13]}, // add options
	{reloadAfterSubmit:false} // del options
	);
	jQuery("#client").filterToolbar({searchOnEnter:false});
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
    <table id="client"></table>
	<div id="client_pager"></div>
    
  </tr>
   <tr>
  <td><?php include'footer.php';?></td>
  </tr>

</table>

	
</body>

</html>