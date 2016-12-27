<?php require_once('Connections/mysqlconn.php'); ?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


$colname_sample_rs = "-1";
if (isset($_GET['search_id'])) {
  $colname_sample_rs = $_GET['search_id'];
}
mysql_select_db($database_mysqlconn, $mysqlconn);
$query_sample_rs = sprintf("SELECT * FROM sample WHERE id = %s ORDER BY name ASC", GetSQLValueString($colname_sample_rs, "int"));
$sample_rs = mysql_query($query_sample_rs, $mysqlconn) or die(mysql_error());
$row_sample_rs = mysql_fetch_assoc($sample_rs);
$totalRows_sample_rs = mysql_num_rows($sample_rs);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sample retrive</title>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="get" name="search_form">
Enter Id to search : <input value="<?php echo $_POST['search_card_id']; ?>" name="search_id" type="text" />
<input name="search_btn" type="button" value="Search" />
</form>

</body>
</html>
<?php
mysql_free_result($sample_rs);
?>
