<?php require_once('Connections/test1.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$maxRows_FileList = 10;
$pageNum_FileList = 0;
if (isset($_GET['pageNum_FileList'])) {
  $pageNum_FileList = $_GET['pageNum_FileList'];
}
$startRow_FileList = $pageNum_FileList * $maxRows_FileList;

mysql_select_db($database_test1, $test1);
$query_FileList = "SELECT id, username, date, filename, extension FROM filestores";
$query_limit_FileList = sprintf("%s LIMIT %d, %d", $query_FileList, $startRow_FileList, $maxRows_FileList);
$FileList = mysql_query($query_limit_FileList, $test1) or die(mysql_error());
$row_FileList = mysql_fetch_assoc($FileList);

if (isset($_GET['totalRows_FileList'])) {
  $totalRows_FileList = $_GET['totalRows_FileList'];
} else {
  $all_FileList = mysql_query($query_FileList);
  $totalRows_FileList = mysql_num_rows($all_FileList);
}
$totalPages_FileList = ceil($totalRows_FileList/$maxRows_FileList)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<table border="1">
  <tr>
    <td>id</td>
    <td>username</td>
    <td>date</td>
    <td>filename</td>
    <td>extension</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_FileList['id']; ?></td>
      <td><?php echo $row_FileList['username']; ?></td>
      <td><?php echo $row_FileList['date']; ?></td>
      <td><?php echo $row_FileList['filename']; ?></td>
      <td><?php echo $row_FileList['extension']; ?></td>
    </tr>
    <?php } while ($row_FileList = mysql_fetch_assoc($FileList)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($FileList);
?>
