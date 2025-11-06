<?php require_once('Connections/cafeteria_system.php'); ?>
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
	$email = $_POST['email'];
	mysql_select_db($database_cafeteria_system, $cafeteria_system);
	$query_cust = "SELECT * FROM customer WHERE s_email = '$email'";
	$Cust = mysql_query($query_cust, $cafeteria_system) or die(mysql_error());
	$row_Cust = mysql_fetch_assoc($Cust);
	$totalRows_Cust = mysql_num_rows($Cust);
	if ( $totalRows_Cust == 0 ) {
		$insertSQL = sprintf("INSERT INTO customer (s_matric, s_name, s_email, s_phone, s_bilik, s_year, s_pass) VALUES (%s, %s, %s, %s, %s, %s, %s)",
						   GetSQLValueString($_POST['matric'], "text"),
						   GetSQLValueString($_POST['name'], "text"),
						   GetSQLValueString($_POST['email'], "text"),
						   GetSQLValueString($_POST['phone'], "text"),
						   GetSQLValueString($_POST['room'], "text"),
						   GetSQLValueString($_POST['year'], "int"),
						   GetSQLValueString($_POST['pass'], "text"));

		mysql_select_db($database_cafeteria_system, $cafeteria_system);
		$Result1 = mysql_query($insertSQL, $cafeteria_system) or die(mysql_error());
		
		$insertGoTo = "student_login.php";
		if (isset($_SERVER['QUERY_STRING'])) {
			$insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
			$insertGoTo .= $_SERVER['QUERY_STRING'];
		}
		
		echo "<script>
				alert('This student has been registered');
				window.location = 'student_login.php';
			  </script>";
		
		//header(sprintf("Location: %s", $insertGoTo));
	} else {
		echo "<script>
				alert('This email has already been registered');
				window.location = 'registration.php';
			  </script>";
	}

  
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
					<img src="images/logo.png" width="20%" alt="" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cafeteria Ordering System
	      </a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbars-rs-food" aria-controls="navbars-rs-food" aria-expanded="false" aria-label="Toggle navigation">
				  <span class="navbar-toggler-icon"></span>				</button>
				<div class="collapse navbar-collapse" id="navbars-rs-food">
					<ul class="navbar-nav ml-auto">
						<li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
						<li class="nav-item"><a class="nav-link" href="menu_1.php">Menu</a></li>
						<li class="nav-item active"><a class="nav-link" href="registration.php">Registration</a></li>
						<li class="nav-item"><a class="nav-link" href="student_login.php">Student Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="admin_login.php">Admin Login</a></li>
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
					<h1>Student Registration</h1>
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
						<h2>Student Registration</h2>
						<p>Enter your details</p>
						<div class="container">
                        <br>
                          <form name="form1" method="POST" action="<?php echo $editFormAction; ?>" onSubmit="return ValidationEvent()">
                            <div align="left">Matric Number :</div>
                              <div class="form-group">
                            <input type="text" class="form-control" id="matric" placeholder="Enter your matric number" name="matric" required>
                            </div>
                            <div align="left">Name :</div>
                            <div class="form-group">
                              <input type="text" class="form-control" id="name" placeholder="Full Name" name="name" pattern="[A-Za-z ]+" title="Text only"required>
                            </div>
                            <div align="left">Email :</div>
							  <div class="form-group">
                              <input type="email" class="form-control" id="email" placeholder="student@gmail.com" name="email" required>
                            </div>
                            <div align="left">Phone Number :</div>
                            <div class="form-group">
                            	<input type="phone" class="form-control" id="phone" placeholder="011-01012211" name="phone" pattern="[0-9]{3}-[0-9.]*" inputmode="numeric" title="For example 011-11110000" required>
                            </div>
                            <div align="left">Room Number :</div>
                            <div class="form-group">
                              <input type="text" class="form-control" id="room" placeholder="M-A1-3" name="room" pattern="[A-Za-z]{1}-[A-Za-z]{1}[0-9]{1}-[0-9.]*" title="For example M-A1-1" required>
                            </div>
                            <div align="left">Tahun Daftar di PUO :</div>
                            <div class="form-group">
                              <input type="number" class="form-control" id="year" placeholder="2000" name="year" pattern="[0-9]{4}" title="For example 2019" required>
                            </div>
                            <div align="left">Password :</div>
                            <div class="form-group">
                              <input type="password" class="form-control" id="pass" placeholder="@Student123" name="pass" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters" onChange="onChange()" required> 
                            </div>
                            <div align="left">Confirm Password :</div>
                            <div class="form-group">
                              <input type="password" class="form-control" id="cpass" placeholder="@Student123" name="cpass" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters" onChange="onChange()" required> 
                            </div>
							  <br>
                            <button type="submit" class="btn btn-default">Register</button>
                            &nbsp;&nbsp;
                            <button type="reset" class="btn btn-default">Reset</button>
                            <input type="hidden" name="MM_insert" value="form1">
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