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

$usernameTemp;
if ( isset($_SESSION['MM_Username']) ) {
    $usernameTemp = $_SESSION['MM_Username'];
} else {
    $usernameTemp = "";
}

$colname_Recordset1 = $usernameTemp;

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO feedback (s_matric, categoryid, s_feed) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['matric'], "text"),
                       GetSQLValueString($_POST['gerai'], "int"),
                       GetSQLValueString($_POST['feed'], "text"));

  mysql_select_db($database_cafeteria_system, $cafeteria_system);
  $Result1 = mysql_query($insertSQL, $cafeteria_system) or die(mysql_error());

  $insertGoTo = "student_feedback.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  echo "<script>
				alert('Thank You! Your Feedback has been sent');
				window.location = 'student_feedback.php';
			  </script>";
			  
}
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

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
    <link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
</head>

<body>
	<!-- Start header -->
	<header class="top-navbar">
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<div class="container">
				<a class="navbar-brand" href="index.php">
					<img src="images/logo.png" width="20%" alt="" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cafeteria Ordering System	      </a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbars-rs-food" aria-controls="navbars-rs-food" aria-expanded="false" aria-label="Toggle navigation">
				  <span class="navbar-toggler-icon"></span>				</button>
				<div class="collapse navbar-collapse" id="navbars-rs-food">
					<ul class="navbar-nav ml-auto">
						<li class="nav-item"><a class="nav-link" href="student_gerai_1.php">Order</a></li>
                        <li class="nav-item"><a class="nav-link" href="student_check_order.php">Check Order</a></li>
                        <li class="nav-item active"><a class="nav-link" href="student_feedback.php">Feedback</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo $logoutAction ?>">LOG OUT</a></li>
				  </ul>
				</div>
			</div>
		</nav>
	</header>
	<!-- End header -->
	
	<!-- Start All Pages -->
	<div class="all-page-title page-breadcrumb">
		<div class="container text-center">
			<div class="row">
				<div class="col-lg-12">
					<h1>Feedback</h1>
				</div>
			</div>
		</div>
	</div>
	<!-- End All Pages -->
	
	<!-- Start Menu -->
	<div class="menu-box">
<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="heading-title text-center">
						<h2>Feedback</h2>
						<p>Sent a feedback to Us !</p>
						<div class="container">
                        <br>
                          <form name="form1" method="POST" action="<?php echo $editFormAction; ?>" onSubmit="return ValidationEvent()">
                            <div align="left">Matric Number :</div>
                              <div class="form-group">
                            <input type="text" value="<?php echo $usernameTemp;?>" class="form-control" id="matric" name="matric" disabled>
                            </div>
                            <div align="left">Stall :</div>
                              <div class="form-group">
							<select class="custom-select d-block form-control" name="gerai" id="gerai" required>
                                <option value="">Please Select Stall*</option>
                                <option value="1">Gerai Sentosa</option>
                                <option value="2">Gerai Seri</option>
                                <option value="3">Gerai Selera</option>
                              </select>
                            </div>
                            <div align="left">Feedback Comment :</div>
                              <div class="form-group">
                            <input type="text" class="form-control" id="feed" placeholder="Your Message" name="feed" required>
                            </div>
                            <br>
                            <button type="submit" class="btn btn-default">Send Message</button>
                              
<button type="reset" class="btn btn-default">Reset</button>
                            <input type="hidden" name="MM_insert" value="form1">
                            <input type="hidden" name="matric" value="<?php echo $usernameTemp;?>">
						</form>
					</div>
				  </div>
				</div>
			</div>		  
	  </div>
	</div>
	<!-- End Menu -->
	
	<script type = "text/javascript">
      function ValidationEvent() {
// Storing Field Values In Variables
var name = document.getElementById("name").value;
// Conditions
if (name != '') {
//alert("Register has been successfully.");
return true;
} else {
//alert("All fields are required.....!");
return false;
}
}
</script>
	
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
   function onChange() {
  const password = document.querySelector('input[name=pass]');
  const confirm = document.querySelector('input[name=cpass]');
  if (confirm.value === pass.value) {
    confirm.setCustomValidity('');
  } else {
    confirm.setCustomValidity('Passwords do not match');
  }
}
</script>
</body>
</html>
