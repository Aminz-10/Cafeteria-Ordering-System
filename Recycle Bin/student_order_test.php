<?php require_once('Connections/cafeteria_system.php'); ?><?php
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
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

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
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO ordering (s_matric, menu_id, quantity, `date`, `time`, order_note) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['matric'], "text"),
                       GetSQLValueString($_POST['menuID'], "text"),
                       GetSQLValueString($_POST['quantity'], "int"),
                       GetSQLValueString($_POST['date'], "date"),
                       GetSQLValueString($_POST['time'], "date"),
                       GetSQLValueString($_POST['note'], "text"));

  mysql_select_db($database_cafeteria_system, $cafeteria_system);
  $Result1 = mysql_query($insertSQL, $cafeteria_system) or die(mysql_error());

  $insertGoTo = "student_order.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?><!DOCTYPE html>
<html lang="en"><!-- Basic -->
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">   
   
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
 
     <!-- Site Metas -->
    <title>Cafeteria Ordering System</title>  
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Site Icons -->
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">    
	<!-- Site CSS -->
    <link rel="stylesheet" href="css/style.css">    
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/custom.css">


    <script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
    <script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
    <script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
    <link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
    <style type="text/css">
<!--
.style2 {font-size: 18px; }
-->
    </style>
    <link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css">
    <link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css">
</head>

<body>
	<!-- Start header -->
	<header class="top-navbar">
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<div class="container">
				<a class="navbar-brand" href="index.php">
					<img src="images/logo.png" width="20%" alt="" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cafeteria Ordering System
				</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbars-rs-food" aria-controls="navbars-rs-food" aria-expanded="false" aria-label="Toggle navigation">
				  <span class="navbar-toggler-icon"></span>				</button>
				<div class="collapse navbar-collapse" id="navbars-rs-food">
					<ul class="navbar-nav ml-auto">
						<li class="nav-item"><a class="nav-link" href="s_menu_pak_abu.php">Menu</a></li>
						<li class="nav-item active"><a class="nav-link" href="student_order.php">Order</a></li>
                        <li class="nav-item"><a class="nav-link" href="student_check_order.php">Check Order</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo $logoutAction ?>">LOG OUT</a></li>
					</ul>
				</div>
			</div>
		</nav>
	</header>
	<!-- End header -->
	
	<!-- Start header -->
	<div class="all-page-title page-breadcrumb">
		<div class="container text-center">
			<div class="row">
				<div class="col-lg-12">
					<h1>Order</h1>
				</div>
			</div>
		</div>
	</div>
	<!-- End header -->
	
	<!-- Start About -->
	<div class="about-section-box">
    <div class="container">
                        <br>
<form action="<?php echo $editFormAction; ?>" name="form1" method="POST" onSubmit="return ValidationEvent()">
                            <div align="left">Matric Number :</div>
                              <div class="form-group">
                            <input type="text" class="form-control" id="matric" placeholder="01DDT19F1122" name="matric" required>
                            </div>
                            <div align="left">Menu ID :</div>
                            <div class="form-group">
                              <input type="text" class="form-control" id="menuID" placeholder="Enter Menu ID" name="menuID" required>
                            </div>
                            <div align="left">Quantity :</div>
                            <div class="form-group">
                              <input type="number" class="form-control" id="quantity" placeholder="1-10" name="quantity" required>
                            </div>
                            <div align="left">Date :</div>
                            <div class="form-group">
                              <input type="date" class="form-control" id="date" placeholder="choose a date" name="date" required>
                            </div>
                            <div align="left">Time :</div>
                            <div class="form-group">
                              <input type="time" class="form-control" id="time" placeholder="Choose your time to pick up" name="time" required>
                            </div>
                            <div align="left">Order Note :</div>
                            <div class="form-group">
                              <input type="text" class="form-control" id="note" placeholder="Please write less than 150 letters." name="note" required>
                            </div>
                            <br>
                            <button type="submit" class="btn btn-default">ORDER</button>
                            <input type="hidden" name="MM_insert" value="form1">
</form>
	  </div>
</div>
<!-- End About -->
	

	
	<!-- Start Contact info -->	<!-- End Contact info -->
	
	<!-- Start Footer -->
	<footer class="footer-area bg-f">
		<div class="container">
			<div class="row">
				<div class="col-md-6 offset-lg-5 col-lg-3">
					<h3>Opening hours</h3>
					<p><span class="text-color">Monday: </span>7:Am - 10PM</p>
					<p><span class="text-color">Tue-Wed :</span> 7:Am - 10PM</p>
					<p><span class="text-color">Thu-Fri :</span> 7:Am - 10PM</p>
					<p><span class="text-color">Sat-Sun :</span> 7:PM - 10PM</p>
				</div>
			</div>
		</div>
		
<div class="copyright">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<p class="company-name">All Rights Reserved. &copy; 2021 <a href="#">Cafeteria Ordering System</a></p>
					</div>
				</div>
			</div>
	  </div>
		
	</footer>
	<!-- End Footer -->
	
	<a href="#" id="back-to-top" title="Back to top" style="display: none;">&uarr;</a>

	<!-- ALL JS FILES -->
	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
    <!-- ALL PLUGINS -->
	<script src="js/jquery.superslides.min.js"></script>
	<script src="js/images-loded.min.js"></script>
	<script src="js/isotope.min.js"></script>
	<script src="js/baguetteBox.min.js"></script>
	<script src="js/form-validator.min.js"></script>
    <script src="js/contact-form-script.js"></script>
    <script src="js/custom.js"></script>
    <script type = "text/javascript">
      function ValidationEvent() {
// Storing Field Values In Variables
var menuID = document.getElementById("menuID").value;
// Conditions
if (menuID != '') {
alert("Order has been successfully.");
return true;
} else {
alert("All fields are required.....!");
return false;
}
}
</script>
    
</body>
</html>