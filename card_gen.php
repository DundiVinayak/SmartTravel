<?php 
$hostname_mysqlconn = "localhost";
$database_mysqlconn = "smart_travel";
$username_mysqlconn = "root";
$password_mysqlconn = "";
$mysqlconn = mysql_pconnect($hostname_mysqlconn, $username_mysqlconn, $password_mysqlconn) or trigger_error(mysql_error(),E_USER_ERROR); 
 $selected = mysql_select_db($database_mysqlconn,$mysqlconn) or die("Could not select db");
	$q = "SELECT MAX(reg_id) as reg_id from passenger";
  $query = mysql_query($q) or die(mysql_errno());

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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "card_g")) {
  $insertSQL = sprintf("INSERT INTO card1 (card_id, reg_id) VALUES (%s, %s)",
                       GetSQLValueString($_POST['get_card_id'], "int"),
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

$colname_card_g = "-1";
if (isset($_POST['get_card_id'])) {
  $colname_card_g = $_POST['get_card_id'];
}
mysql_select_db($database_mysqlconn, $mysqlconn);
$query_card_g = sprintf("SELECT * FROM card1 WHERE card_id = %s ORDER BY card_id ASC", GetSQLValueString($colname_card_g, "int"));
$card_g = mysql_query($query_card_g, $mysqlconn) or die(mysql_error());
$row_card_g = mysql_fetch_assoc($card_g);
$totalRows_card_g = mysql_num_rows($card_g);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>

<table width="455" border="0" cellspacing="0" cellpadding="10">
  <caption>
    Card Generation
  </caption>
  <form id="form1" name="card_g" method="POST" action="<?php echo $editFormAction; ?>">
  <tr>
    <td width="97">Card No :</td>
    <td width="164"><label for="card_id"></label>
      <input type="text" name="get_card_id" id="card_id" /></td>
          
  </tr>
  <tr>
    <td>Reg Id : </td>
    <td><label for="reg_id"></label>
      <input type="text" name="reg_id"  /></td>

  </tr>
  <tr>
        <td>&nbsp;</td>  
  <td width="134"><input type="submit" name="card_submit" id="card_submit" value="Submit" /></td>
  </tr>
  
  <input type="hidden" name="MM_insert" value="card_g" />
    </form>
</table>
<?php 
while($row = mysql_fetch_assoc($query)){
	echo "Last Generated Registration ID : ".$row['reg_id'];} ?>
</body>
</html>
<?php
mysql_free_result($card_g);
?>
