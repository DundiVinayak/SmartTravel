<?php 
$username = "root";
$password = "";
$hostname = "localhost"; 
$dbname   = "smart_travel";
$dbhandle = mysql_connect($hostname, $username, $password) or die(mysql_error());
  $selected = mysql_select_db($dbname,$dbhandle) or die("Could not select db");

error_reporting(0);?>
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title></title>
</head>
<body>

<form method="post" action="search_card.php" name="myform">
	<table align="center" >
		<tr>
			<td><label for=""> Enter card Id :</label></td>
			<td><input type="text" name="search_id" ></td>
		</tr>

		<tr>
			<td colspan="2" align="center"><input type="submit" name="submit" value="search"/></td>
		</tr>
	</table>
</form>
</body>
</html>
<?php
if(isset($_POST['submit']))
{
    $search_id=mysql_real_escape_string($_REQUEST['search_id']);
//    echo "connection established";
    $result=mysql_query("SELECT card_id, first_name, last_name, gender, phone_number, aadhar_number, bal_amount, doi FROM passenger as p , card1 as c where c.card_id = '$search_id' and p.reg_id = c.reg_id") or die(mysql_error($result)); 
	
    if(mysql_num_rows($result) > 0) {
		while($on=  mysql_fetch_array($result)){
?>

<?php echo "Card ID : ".$on["card_id"] ?><br>
<?php echo "Name : ".$on["first_name"]." ".$on["last_name"] ?><br>
<?php echo "Gender : ".$on["gender"] ?><br>
<?php echo "Phone Number : ".$on["phone_number"] ?><br>
<?php echo "Aadhar Number : ".$on["aadhar_number"] ?><br>
<?php echo "Balance : ".$on["bal_amount"] ?><br>
<?php echo "DOI : ".$on["doi"] ?><br>



<?php }}}?>