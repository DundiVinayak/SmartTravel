<?php require_once('Connections/mysqlconn.php'); ?>
<?php
  $query = mysql_query("SELECT MAX(reg_id) from passenger");
?>
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "card_alot_form")) {
  $insertSQL = sprintf("INSERT INTO card1 (card_id, reg_id) VALUES (%s, %s)",
                       GetSQLValueString($_POST['set_card_id'], "int"),
                       GetSQLValueString($_POST['reg_id'], "int"));

  mysql_select_db($database_mysqlconn, $mysqlconn);
  $Result1 = mysql_query($insertSQL, $mysqlconn) or die(mysql_error());

  $insertGoTo = "card_gen_succes.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$colname_card_alot_rs = "-1";
if (isset($_POST['card_id'])) {
  $colname_card_alot_rs = $_POST['card_id'];
}
mysql_select_db($database_mysqlconn, $mysqlconn);
$query_card_alot_rs = sprintf("SELECT * FROM card1 WHERE card_id = %s ORDER BY card_id ASC", GetSQLValueString($colname_card_alot_rs, "int"));
$card_alot_rs = mysql_query($query_card_alot_rs, $mysqlconn) or die(mysql_error());
$row_card_alot_rs = mysql_fetch_assoc($card_alot_rs);
$totalRows_card_alot_rs = mysql_num_rows($card_alot_rs);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Card Allotment</title>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="POST" name="card_alot_form">
Enter Card Id<input name="set_card_id" type="text" />
Enter Reg Id<input name="reg_id" type="text" /><br />
<input name="submit_btn" type="button" value="Allot Card" />
<input type="hidden" name="MM_insert" value="card_alot_form" />
</form>
</body>
</html>
<?php
mysql_free_result($card_alot_rs);
?>
