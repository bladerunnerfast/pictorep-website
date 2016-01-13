<?php 
include('prp_functions.php');
check_access();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title>Pictorep | Home</title>
<link rel="stylesheet" type="text/css" href="style.css"/>

<!--Javascrip code started here-->

<link rel="stylesheet" type="text/css" href="support/jquery-ui-1.9.1.custom.min.css" />
<link rel="stylesheet" type="text/css" href="support/ui.jqgrid.css" /> <!--This file is required for theme setup-->

<script src="support/jquery-1.7.2.min.js" type="text/javascript"></script>
<script src="support/jquery-ui-1.9.1.custom.min.js" type="text/javascript"></script>
<script src="support/grid.locale-en.js" type="text/javascript"></script>
<script src="support/jquery.jqGrid.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
	var mygrid = jQuery("#jobs").jqGrid({
		url:"jobs_search.php?q=1",
		datatype: "json",
		autowidth: true,
		height: 580,
		colNames:['ID', 'Client Name','Job Name','Service', 'Quantity', 'Format', 'Turnaround', 'Instruction','Status'],
		colModel:
		[
			{name:'id',index:'id',search:false, width:'50'},
			{name:'name',index:'name', search:true},
			{name:'job',index:'job', search:true},
			{name:'service',index:'service',search:false},
			{name:'quantity',index:'quantity',search:false},
			{name:'format',index:'format',search:false},
			{name:'turnaround',index:'turnaround',search:false},
			{name:'message',index:'message',search:false},
			{name:'status',index:'quotation', search:false, 
				editable:true, 
				edittype:"select", 
				alight:'centre', 
				formatter:'select',
				editrules:{required:true},
				editoptions:{value:'1:select;2:inprogress;3:correction;4:onhold;5:under-review;6:cancelled;7:completed'},
			
			}
		],
		rowNum:25,
		mtype: "POST",
		rowList:[25,50,100],
		pager: '#jobs_pager',
		sortname: 'id',
		sortorder: "asc",
		viewrecords: true,
		cellEdit:true,
		cellsubmit:'remote',
		cellurl:'jobs_search.php',
		rownumbers: true,
		gridview : true,
		footerrow : true,
		ExpandColClick : true,
		editurl: "jobs_edit.php",
		hidegrid:false,
		//toppager:true,
		caption:"", //this appears just above the columns name whatever string put inside of it
		cellLayout:2,
		altRows:true,
		
		
		loadError : function(xhr,st,err) {
			jQuery("#jobs").html("Type: "+st+"; Response: "+ xhr.status + " "+xhr.statusText);
		}
	});
	
	jQuery("#jobs").jqGrid('navGrid','#jobs_pager',
	{edit:true,add:true,del:true,search:true,refresh:true,view:true},
	{height:'auto',width:'auto',reloadAfterSubmit:true, closeAfterEdit:true, closeOnEscape:true,savekey:[true,13]}, // edit options
	{height:'auto',width:'auto',reloadAfterSubmit:true, closeAfterAdd:true, closeOnEscape:true,savekey:[true,13]}, // add options
	{reloadAfterSubmit:false} // del options
	);
	jQuery("#jobs").filterToolbar({searchOnEnter:false}); //disabling this will distable the column search option
});

</script>



<!--Javascrip code ended here-->

</head>
<body>
<table id="main_menu" width="100%" border="0" align="center" bgcolor="#e6e4da">
  <tr>
    <td><?php include('header.php') ?></td>
  </tr>
  <tr>
    <table id="jobs">
    </table>
    <div id="jobs_pager"></div>
  </tr>
  <tr>
  <td><?php include'footer.php';?></td>
  </tr>
  
</table>
</body>
</html>