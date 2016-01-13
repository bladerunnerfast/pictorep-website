<?php 
require_once('prp_connect.php');
require 'prp_functions.php'; //functions.php has some functions declared that will be necessary in this page
check_access();

$examp = $_GET["q"]; //query number

$page = $_POST['page']; // get the requested page
$limit = $_POST['rows']; // get how many rows we want to have into the grid
$sidx = $_POST['sidx']; // get index row - i.e. user click to sort
$sord = $_POST['sord']; // get the direction
if(!$sidx) $sidx =1;

switch ($examp) {
    case 1:
		$result = mysql_query("
		SELECT COUNT(*) AS count 
		FROM client_data");
		$row = mysql_fetch_array($result,MYSQL_ASSOC);
		$count = $row['count'];

		if( $count >0 ) {
			$total_pages = ceil($count/$limit);
		} else {
			$total_pages = 0;
		}
        if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit; // do not put $limit*($page - 1)
        if ($start<0) $start = 0;
        $SQL = "
		SELECT *
		FROM client_data 
		ORDER BY ".$sidx." ".$sord. " LIMIT ".$start." , ".$limit;
		
		$result = mysql_query( $SQL ) or die("Could not execute query.".mysql_error());
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i=0;
		while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
		
		$responce->rows[$i]['id']=$row['id'];
            	$responce->rows[$i]['cell']=array($row[id],$row[name],$row[company],$row[email],$row[website],$row[address],$row[country],$row[phone]);
            	$i++;
		} 
		//echo $json->encode($responce); // coment if php 5
        echo json_encode($responce);
           
        break;
}
//mysql_close($connect);
?>