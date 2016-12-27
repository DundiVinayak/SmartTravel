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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "reg_form")) {
  $insertSQL = sprintf("INSERT INTO passenger (first_name, last_name, father_name, gender, dob, address, city, pincode, email_id, phone_number, aadhar_number, photo) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['fname'], "text"),
                       GetSQLValueString($_POST['lname'], "text"),
                       GetSQLValueString($_POST['father_name'], "text"),
                       GetSQLValueString($_POST['gender'], "text"),
                       GetSQLValueString($_POST['dob'], "date"),
                       GetSQLValueString($_POST['address'], "text"),
                       GetSQLValueString($_POST['city'], "text"),
                       GetSQLValueString($_POST['pincode'], "double"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['phone'], "double"),
                       GetSQLValueString($_POST['aadhar'], "double"),
                       GetSQLValueString($_POST['photo'], "text"));

  mysql_select_db($database_mysqlconn, $mysqlconn);
  $Result1 = mysql_query($insertSQL, $mysqlconn) or die(mysql_error());

  $insertGoTo = "card_gen.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$colname_registration_rs = "-1";
if (isset($_GET['reg_id'])) {
  $colname_registration_rs = $_GET['reg_id'];
}
mysql_select_db($database_mysqlconn, $mysqlconn);
$query_registration_rs = sprintf("SELECT * FROM passenger WHERE reg_id = %s ORDER BY reg_id ASC", GetSQLValueString($colname_registration_rs, "int"));
$registration_rs = mysql_query($query_registration_rs, $mysqlconn) or die(mysql_error());
$row_registration_rs = mysql_fetch_assoc($registration_rs);
$totalRows_registration_rs = mysql_num_rows($registration_rs);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="css/bootstrap-theme.css" />
    <link rel="stylesheet" href="css/bootstrap.min.css" />

    <title>Registration of SMART TRAVEL</title>

    <style type="text/css">
        body {
	       background-color: #9CC;
        }
    </style>
</head>

<body>
    <div class="container">
    <table>

        <form role="form" action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="reg_form">

            <tr>
                <div class="form-group">
                <td><label for="fname">First Name :</label></td>
                    <td><input type="text" name="fname" id="fname" required="required" placeholder="First Name" /></td></div>
            </tr>

            <tr>
                <div class="form-group">
                <td><label for="fname">Last Name :</label></td>
                    <td><input type="text" name="lname" id="lname" required="required" /></td></div>
            </tr>
            
            <tr>
                <div class="form-group">
                <td><label for="textfield">Father Name :</label></td>
                    <td><input type="text" name="father_name" id="textfield" required="required" /></td></div>
            </tr>
            
            <tr>
                <div class="form-group">
                <td><strong>Gender : </strong></td>
                <td>
                    <input type="radio" name="gender" id="gender" value="male" />
                    <label for="male">Male</label>
                    <input type="radio" name="gender" id="gender" value="female" />
                    <label for="female">Female</label>
                    </td></div>
            </tr>
            
            <tr>
                <td><label for="dob">Date of Birth  : </label></td>
                <td><input type="date" name="dob" id="dob" required="required"/></td>
            </tr>
            
            <tr>
                <td><label for="adress">Address :</label></td>
                <td><textarea name="address" id="address" cols="23" rows="2"></textarea></td>
            </tr>
            <tr>
                <td><label for="pincode">Pincode : </label></td>
                <td><input type="text" name="pincode" id="pincode" required="required" placeholder="Pincode" /></td>
            </tr>  
            <tr>
                <td><label for="city">City : </label></td>
                <td><input type="text" name="city" id="city" required="required" placeholder="City" /></td>
            </tr>  
            
            <tr>
                <td><label for="phone">Mobile Number :</label></td>
                <td><input type="text" name="phone" id="phone" placeholder="Mobile Number" /></td>
            </tr>
            
            <tr>
                <td><label for="email">Email Id : </label></td>
                <td><input type="email" name="email" id="email" required="required" placeholder="username@company.com" /></td>
            </tr>
            
            <tr>
                <td><label for="aadhar">Aadhar Card Number : </label></td>
                <td><input type="text" name="aadhar" id="aadhar" required="required" placeholder="aadhar number" /></td>
            </tr>  
            
            <tr>
                <td><label for="photo">Upload recent Passport size Photo : </label></td>
                <td><input type="file" accept="image/*" name="photo" id="photo" required="required" /></td>
            </tr>
            
            <tr>
                <td></td>
                <td>
	<div class="btn-group">
                        <input type=submit value=Register>
                    </div>    
                        
                </td>
            </tr>
            <input type="hidden" name="MM_insert" value="reg_form" />
        </form>
    </table>
    </div>
</body>
</html>
<?php
mysql_free_result($registration_rs);
?>
