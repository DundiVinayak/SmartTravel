<?php require_once('Connections/mysqlconn.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
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

$colname_search_card = "-1";
if (isset($_GET['searc_card_id'])) {
  $colname_search_card = $_GET['search_card_id'];
}
mysql_select_db($database_mysqlconn, $mysqlconn);
$query_search_card = sprintf("SELECT * FROM card1 WHERE card_id = %s ORDER BY card_id DESC", GetSQLValueString($colname_search_card, "int"));
$search_card = mysql_query($query_search_card, $mysqlconn) or die(mysql_error());
$row_search_card = mysql_fetch_assoc($search_card);
$totalRows_search_card = mysql_num_rows($search_card);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>HOME </title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <!-- Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<link href="css/animate.css" rel="stylesheet" />
    <!-- Squad theme CSS -->
    <link href="css/style.css" rel="stylesheet">
	<link href="color/default.css" rel="stylesheet">

</head>

<body id="page-top" data-spy="scroll" data-target=".navbar-custom">
	<!-- Preloader -->
	<div id="preloader">
	  <div id="load"></div>
	</div>

    <nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="#">
                    <h1>SMART TRAVEL</h1>
                </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
      <ul class="nav navbar-nav">
        <li class="active"><a href="home.php">Home</a></li>
        <li><a href="registration.php">Registration</a></li>
		<li><a href="card_type.html">Card Types</a></li>
<li class="dropdown" id="login">
            <a href="#" id="login-trigger" class="dropdown-toggle" data-toggle="dropdown">Payment <b class="caret"></b></a>
            
            <ul class="dropdown-menu" style="width:220px; padding:10px 30px 10px;  opacity: .86;" >
                
                <form ACTION="<?php echo $_POST['search_card_id']; ?>" METHOD="POST" role="form" name="login_form" class="form-horizontal" >
                    <div class="form-group">
                        <input type="text" name="search_card_id" class="form-control" placeholder="Enter Card Id " >
                    </div> <button type="submit" class="btn btn-default">Search</button>
                    </form>
            </ul>
        </li>
        <li><a href="statistics.html">Statistics</a></li>
        <li><a href="<?php echo $logoutAction ?>">Logout</a></li>
      </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

	<!-- Section: intro -->

    <section id="intro" class="intro">
		<div class="container">
			<div class="row">
            <?php 
			if (!$search_card) {
    			echo "Could not successfully run query ($sql) from DB: " . mysql_error();
    			exit;
			} ?>
  <?php echo "Card Id".$row_search_card["card_id"]; ?>
  <?php echo "Balance ".$row_search_card["bal_amount"]; ?>
  <?php echo "DOI".$row_search_card["doi"]; ?>
			</div>
        </div>
    </section>

	<!-- /Section: intro -->
	<footer>
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-lg-12">
					<div class="wow shake" data-wow-delay="0.4s">
					<div class="page-scroll marginbot-30">
						<a href="#intro" id="totop" class="btn btn-circle">
							<i class="fa fa-angle-double-up animated"></i>
						</a>
					</div>
					</div>
					<p>&copy;Copyright 2015. All rights reserved.</p>
				</div>
			</div>	
		</div>
	</footer>

    <!-- Core JavaScript Files -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.easing.min.js"></script>	
	<script src="js/jquery.scrollTo.js"></script>
	<script src="js/wow.min.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="js/custom.js"></script>

</body>

</html>
<?php
mysql_free_result($search_card);
?>
