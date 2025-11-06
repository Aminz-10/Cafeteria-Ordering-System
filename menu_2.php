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

mysql_select_db($database_cafeteria_system, $cafeteria_system);
$query_Menu = "SELECT menu_id, menu_photo, menu_name, menu_price FROM cafeteria WHERE categoryid = 2 ORDER BY menu_id ASC";
$Menu = mysql_query($query_Menu, $cafeteria_system) or die(mysql_error());
$row_Menu = mysql_fetch_assoc($Menu);
$totalRows_Menu = mysql_num_rows($Menu);

mysql_select_db($database_cafeteria_system, $cafeteria_system);
$query_Gerai_1 = "SELECT gerai FROM category WHERE categoryid = 1";
$Gerai_1 = mysql_query($query_Gerai_1, $cafeteria_system) or die(mysql_error());
$row_Gerai_1 = mysql_fetch_assoc($Gerai_1);
$totalRows_Gerai_1 = mysql_num_rows($Gerai_1);

mysql_select_db($database_cafeteria_system, $cafeteria_system);
$query_Gerai_2 = "SELECT gerai FROM category WHERE categoryid = 2";
$Gerai_2 = mysql_query($query_Gerai_2, $cafeteria_system) or die(mysql_error());
$row_Gerai_2 = mysql_fetch_assoc($Gerai_2);
$totalRows_Gerai_2 = mysql_num_rows($Gerai_2);

mysql_select_db($database_cafeteria_system, $cafeteria_system);
$query_Gerai_3 = "SELECT gerai FROM category WHERE categoryid = 3";
$Gerai_3 = mysql_query($query_Gerai_3, $cafeteria_system) or die(mysql_error());
$row_Gerai_3 = mysql_fetch_assoc($Gerai_3);
$totalRows_Gerai_3 = mysql_num_rows($Gerai_3);
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

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
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
						<li class="nav-item active"><a class="nav-link" href="#">Menu</a></li>
						<li class="nav-item"><a class="nav-link" href="registration.php">Registration</a></li>
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
					<h1>Special Menu</h1>
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
						<h2>Menu</h2>
						<p>Sedap...Try ah</p>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="special-menu text-center">
						<div class="button-group filter-button-group">
							<button onClick="location.href='menu_1.php'"><?php echo $row_Gerai_1['gerai']; ?></button>
							<button class="active"><?php echo $row_Gerai_2['gerai']; ?></button>
						  	<button onClick="location.href='menu_3.php'"><?php echo $row_Gerai_3['gerai']; ?></button>
						</div>
					</div>
				</div>
			</div>
				
			<br>
            <div align="center">
              <table class="table-striped" width="60%" border="0" cellpadding="10">
                <tr>
                  <td><div align="center"><strong>Photo</strong></div></td>
                  <td><div align="center"><strong>Menu Name</strong></div></td>
                  <td><div align="center"><strong>Price</strong></div></td>
                </tr>
                <?php do { ?>
                  <tr>
                    <td><div align="center"><img src="<?php echo $row_Menu['menu_photo']; ?>" height="125px;" width="125px"></div></td>
                    <td><div align="center"><?php echo $row_Menu['menu_name']; ?></div></td>
                    <td><div align="center">RM <?php echo $row_Menu['menu_price']; ?></div></td>
                  </tr>
                  <?php } while ($row_Menu = mysql_fetch_assoc($Menu)); ?>
              </table>
    </div>
		  
	  </div>
	</div>
	<!-- End Menu -->
	
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
mysql_free_result($Menu);

mysql_free_result($Gerai_1);

mysql_free_result($Gerai_2);

mysql_free_result($Gerai_3);
?>
