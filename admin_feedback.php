<?php require_once('Connections/cafeteria_system.php'); ?>
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

?>

<?php
include_once 'connection.php';
if(isset($_POST['save'])){
    $checkbox = $_POST['check'];
    
    
    for ($i=0;$i<count($checkbox);$i++) {
        $del_id = $checkbox[$i]; 
        mysqli_query($con,"DELETE FROM feedback WHERE order_no='".$del_id."'");
        
    }
    
    $message = "Data deleted successfully !";
        
    if(isset($message)) 
    { 
        echo '<script>alert("' . $i . ' order deleted successfully !")</script>';
    }
}
?>

<?php 
	
	$dateTemp = "";
	if (isset($_POST['date'])) {
		$dateData = $_POST['date'];
		$dateTemp = "AND ordering.date = '$dateData'";
	} else {
		$dateTemp = "AND ordering.date = CURDATE()";
	}
	
	$user_id = $_SESSION['MM_Username'];

	mysql_select_db($database_cafeteria_system, $cafeteria_system);
	$query_Admin = "SELECT * FROM admin WHERE a_id = '$user_id'";
	$Admin = mysql_query($query_Admin, $cafeteria_system) or die(mysql_error());
	$row_Admin = mysql_fetch_assoc($Admin);
	$totalRows_Admin = mysql_num_rows($Admin);

	$category_id = null;
	do {
		$category_id = $row_Admin["a_categoryid"];
	} while ($row_Admin = mysql_fetch_assoc($Admin));
	
	$query_ordering = "SELECT * 
			FROM feedback
			LEFT JOIN category ON category.categoryid = feedback.categoryid
			RIGHT JOIN customer ON customer.s_matric = feedback.s_matric
			WHERE category.categoryid = '$category_id'
			ORDER BY no ASC";
	
    mysql_select_db($database_cafeteria_system, $cafeteria_system);
    //$query_ordering = "SELECT * FROM ordering";
    $ordering = mysql_query($query_ordering, $cafeteria_system) or die(mysql_error());
    $row_ordering = mysql_fetch_assoc($ordering);
    $totalRows_ordering = mysql_num_rows($ordering);
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
    <link rel="stylesheet" href="css/custom.css"></head>

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
                        <li class="nav-item"><a class="nav-link" href="admin_ordering.php">Order</a></li>
						<li class="nav-item active"><a class="nav-link" href="admin_feedback.php">Feedback</a></li>
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
					<h1 class="h1">Student Feedback</h1>
			  </div>
		  </div>
		</div>
	</div>
	<!-- End header -->
	
	<!-- Start About -->
	<div class="about-section-box">
		<div class="container">
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
          <table width="100%" border="0" align="center" cellpadding="5" class="table-striped">
            <tr>
              <td width="10%"><div align="center">
                <input type="checkbox" id="checkAl"> 
              Select All</div></td>
              <td width="38%"><div align="center"><strong>Student Matric</strong></div></td>
              <td width="27%"><div align="center"><strong>Student Name</strong></div></td>
              <td width="25%"><div align="center"><strong>Feedback</strong></div></td>
              <!--<td><div align="center"></div></td>-->
              <!--<td><div align="center"></div></td>-->
            </tr>
            <?php do { ?>
              <tr>
                <td><div align="center"><input type="checkbox" id="checkItem" name="check[]" value="<?php echo $row_ordering["order_no"]; ?>"></div></td>
                <td><div align="center"><?php echo $row_ordering['s_matric']; ?></div></td>
                <td><div align="center"><?php echo $row_ordering['s_name']; ?></div></td>
                <td><div align="center"><?php echo $row_ordering['s_feed']; ?></div></td>
                <!--<td><div align="center"><strong><a href="admin_delete_ordering.php?order_no=<?php echo $row_ordering['order_no']; ?>">DELETE</a></strong></div></td>-->
            </tr>
              <?php } while ($row_ordering = mysql_fetch_assoc($ordering)); ?>
          </table>
<div align="center"><br>
              <button type="submit" class="btn btn-success" name="save">DELETE</button>
          </div>
		</form>
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
    <script>
	$("#checkAl").click(function () {
	$('input:checkbox').not(this).prop('checked', this.checked);
	});
	</script>

</body>
</html>
<?php
mysql_free_result($ordering);
?>