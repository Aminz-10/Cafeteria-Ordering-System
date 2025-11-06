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
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "index.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE ordering SET s_matric=%s, menu_id=%s, quantity=%s, `date`=%s, `time`=%s, order_status=%s, order_note=%s WHERE order_no=%s",
                       GetSQLValueString($_POST['s_matric'], "text"),
                       GetSQLValueString($_POST['menu_id'], "text"),
                       GetSQLValueString($_POST['quantity'], "int"),
                       GetSQLValueString($_POST['date'], "date"),
                       GetSQLValueString($_POST['time'], "date"),
                       GetSQLValueString($_POST['status'], "text"),
                       GetSQLValueString($_POST['order_note'], "text"),
                       GetSQLValueString($_POST['order_no'], "int"));

  mysql_select_db($database_cafeteria_system, $cafeteria_system);
  $Result1 = mysql_query($updateSQL, $cafeteria_system) or die(mysql_error());

  $updateGoTo = "admin_ordering.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Recordset1 = "-1";
if (isset($_GET['order_no'])) {
  $colname_Recordset1 = $_GET['order_no'];
}
mysql_select_db($database_cafeteria_system, $cafeteria_system);
$query_Recordset1 = sprintf("SELECT * FROM ordering WHERE order_no = %s", GetSQLValueString($colname_Recordset1, "text"));
$Recordset1 = mysql_query($query_Recordset1, $cafeteria_system) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html>
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


    <style type="text/css">
<!--
.style3 {color: #00FFFF}
.style5 {font-size: 18px}
-->
    </style>
    <script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
    <script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
    <script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
    <link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
    <link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css">
    <link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css">
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
                    <li class="nav-item"><a class="nav-link" href="admin_gerai.php">Gerai</a></li>
						<li class="nav-item"><a class="nav-link" href="admin_menu.php">Menu</a></li>
						<li class="nav-item"><a class="nav-link" href="admin_student.php">Student</a></li>
						<li class="nav-item active"><a class="nav-link" href="admin_ordering.php">Order</a></li>
                        <li class="nav-item"><a class="nav-link" href="admin_feedback.php">Feedback</a></li>
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
					<h1 class="h1">Update Student Order</h1>
			  </div>
		  </div>
		</div>
	</div>
	<!-- End header -->
	
	<!-- Start About -->
	<div class="about-section-box">
		<div class="container">
          <div align="center">
          <form action="<?php echo $editFormAction; ?>" name="form1" method="POST" onSubmit="return ValidationEvent()">
          					<div align="left">Order Number :</div>
                              <div class="form-group">
                             <div align="left"><strong><?php echo $row_Recordset1['order_no']; ?></strong></div>
                            </div>
                            <div align="left">Matric Number :</div>
                              <div class="form-group">
                            <div align="left"><strong><?php echo $row_Recordset1['s_matric']; ?></strong></div>
                            </div>
            <div align="left">Menu ID :</div>
                            <div class="form-group">
                              <div align="left"><strong><?php echo $row_Recordset1['menu_id']; ?></strong></div>
            </div>
                            <div align="left">Quantity :</div>
                            <div class="form-group">
                              <div align="left"><strong><?php echo $row_Recordset1['quantity']; ?></strong></div>
                            </div>
                            <div align="left">Date :</div>
                            <div class="form-group">
                             <div align="left"><strong><?php echo $row_Recordset1['date']; ?></strong></div>
                            </div>
                            <div align="left">Time :</div>
                            <div class="form-group">
                              <div align="left"><strong><?php echo $row_Recordset1['time']; ?></strong></div>
                            </div>
                            <div align="left">Order Note :</div>
                            <div class="form-group">
                              <div align="left"><strong><?php echo $row_Recordset1['order_note']; ?></strong></div>
                            </div>
                            <div align="left">Order Status :</div>
                            <div class="form-group">
                              <!--<input type="text" value="<?php echo htmlentities($row_Recordset1['order_status'], ENT_COMPAT, ''); ?>" class="form-control" id="status" placeholder="" name="status" required><br>--> 
                              <select class="form-control" aria-label="Default select example" id="status" name="status">
                                <option selected><?php echo htmlentities($row_Recordset1['order_status'], ENT_COMPAT, ''); ?></option>
                                <option value="NEW.jpg">NEW ORDER</option>
                                <option value="FINISHED.jpg">FINISHED</option>
                                <option value="TAKEN.png">TAKEN</option>
                              </select>
			</div>
							<br>
                            <button type="submit" class="btn btn-default">UPDATE</button>
                            &nbsp;
			<button onClick="location.href='admin_ordering.php'" class="btn btn-default">BACK</button>
                            
<input type="hidden" name="order_no" value="<?php echo $row_Recordset1['order_no']; ?>">
<input type="hidden" name="s_matric" value="<?php echo $row_Recordset1['s_matric']; ?>">
<input type="hidden" name="menu_id" value="<?php echo $row_Recordset1['menu_id']; ?>">
<input type="hidden" name="quantity" value="<?php echo $row_Recordset1['quantity']; ?>">
<input type="hidden" name="date" value="<?php echo $row_Recordset1['date']; ?>">
<input type="hidden" name="time" value="<?php echo $row_Recordset1['time']; ?>">
<input type="hidden" name="order_note" value="<?php echo $row_Recordset1['order_note']; ?>">
                            <input type="hidden" name="MM_update" value="form1">
			</form>
          </div>
	  </div>
	</div>
	<!-- End About -->
	
	<!-- Start Menu -->
	<div class="menu-box"> </div>
	<!-- End Menu -->
	
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
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset1);
?>