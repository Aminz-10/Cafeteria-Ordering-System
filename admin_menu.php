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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


	$currentDirectory = getcwd();
    //$uploadDirectory = "/upload/";

    $fileExtensionsAllowed = array('jpeg','jpg','png');

    $fileName = $_FILES['filename']['name'];
    $fileSize = $_FILES['filename']['size'];
    $fileTmpName  = $_FILES['filename']['tmp_name'];
    $fileType = $_FILES['filename']['type'];
    $fileExtension = strtolower(end(explode('.',$fileName)));

    $uploadPath = 'upload/' . basename($fileName); 

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
if (! in_array($fileExtension,$fileExtensionsAllowed)) {
        $errors[] = "This file extension is not allowed. Please upload a JPEG or PNG file";
      }

if (empty($errors)) {
$didUpload = move_uploaded_file($fileTmpName, $uploadPath);

$menu_id = $_POST['menuID'];
mysql_select_db($database_cafeteria_system, $cafeteria_system);
	$query_Clie = "SELECT * FROM cafeteria WHERE menu_id = '$menu_id'";
	$Clie = mysql_query($query_Clie, $cafeteria_system) or die(mysql_error());
	$row_Clie = mysql_fetch_assoc($Clie);
	$totalRows_Clie = mysql_num_rows($Clie);
	if ( $totalRows_Clie == 0 ) {
  $insertSQL = sprintf("INSERT INTO cafeteria (menu_id, categoryid, menu_photo, menu_name, menu_price, menu_status) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['menuID'], "text"),
                       GetSQLValueString($category_id, "int"),
                       GetSQLValueString($uploadPath, "text"),
                       GetSQLValueString($_POST['menu'], "text"),
                       GetSQLValueString($_POST['price'], "text"),
                       GetSQLValueString($_POST['menu_status'], "int"));

  mysql_select_db($database_cafeteria_system, $cafeteria_system);
  $Result1 = mysql_query($insertSQL, $cafeteria_system) or die(mysql_error());

  $insertGoTo = "admin_menu.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  echo "<script>
				alert('Menu has been submit');
				window.location = '$insertGoTo';
			  </script>";
	}else{
		echo "<script>
				alert('This Menu ID has already been registered. Please input a new Menu ID');
				window.location = '$insertGoTo';
			  </script>";
	}
	} else {
        foreach ($errors as $error) {
		echo '<script type="text/javascript">alert(" ' . $error . ' These are the errors");window.location = "admin_menu.php";</script>';
        }
      }
}

mysql_select_db($database_cafeteria_system, $cafeteria_system);
$query_admin_menu = "SELECT * FROM cafeteria WHERE categoryid = '$category_id' ORDER BY menu_id ASC";
$admin_menu = mysql_query($query_admin_menu, $cafeteria_system) or die(mysql_error());
$row_admin_menu = mysql_fetch_assoc($admin_menu);
$totalRows_admin_menu = mysql_num_rows($admin_menu);
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


    <script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
    <link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css"></head>

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
					  <li class="nav-item active"><a class="nav-link" href="admin_menu.php">Menu</a></li>
						<li class="nav-item"><a class="nav-link" href="admin_student.php">Student</a></li>
						<li class="nav-item"><a class="nav-link" href="admin_ordering.php">Order</a></li>
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
					<h1>Menu&nbsp;</h1>
			  </div>
			</div>
		</div>
	</div>
	<!-- End header -->
	
	<!-- Start About -->
	<div class="about-section-box">
		<div class="container">
		  <div align="center">
          <form name="form1" method="POST" action="<?php echo $editFormAction; ?>" onSubmit="return ValidationEvent()"  enctype="multipart/form-data">
                            <div align="left">Menu ID :</div>
                              <div class="form-group">
                            <input type="text" class="form-control" id="menuID" placeholder="Enter menu ID" name="menuID" required>
                            </div>
                            <!--<div align="left">Category ID :</div>
                            <div class="form-group">
                              <input type="number" class="form-control" id="ID" placeholder="Number Only" name="ID" min="1" max="3" required>
                            </div>-->
                             <div align="left">Menu Photo :</div>
                            <div class="custom-file mb-3">
                              <input type="file" class="custom-file-input" id="customFile" name="filename" required>
                              <label class="custom-file-label" for="customFile">Choose Photo</label>
            </div>
                            <div align="left">Menu Name :</div>
                            <div class="form-group">
                              <input type="text" class="form-control" id="menu" placeholder="Text Only" name="menu" pattern="[A-Za-z ]+" required>
                            </div>
                             <div align="left">Menu Price :</div>
                            <div class="form-group">
                              <input type="text" class="form-control" id="price" placeholder="RM __.__" name="price" required>
                            </div>
                             <div align="left">Menu Status :</div>
            <div class="form-group">
              <!--<input type="number" class="form-control" id="status" placeholder="0 [is not available] or 1 [is available]" min="0" max="1" name="status" required>-->
              <select class="form-control" aria-label="Default select example" id="menu_status" name="menu_status">
                                <option selected value="1">AVAILABLE [1]</option>
                                <option value="0">NOT AVAILABLE [0]</option>
              </select>
            </div>
							<br>
                            <button type="submit" class="btn btn-default">SUBMIT</button>
                            &nbsp;&nbsp;
                            <button type="reset" class="btn btn-default">Reset</button>
                            <input type="hidden" name="MM_insert" value="form1">
          </form></div>
          <br>
          <br>
          <br>
          <h1 align="center">Menu Table</h1>
          <br>
          <table width="90%" border="0" align="center" cellpadding="5" class="table-striped">
            <tr>
              <td><div align="center"><strong>Menu ID</strong></div></td>
              <td><div align="center"><strong>Menu Photo</strong></div></td>
              <td><div align="center"><strong>Menu Name</strong></div></td>
              <td><div align="center"><strong>Menu Price</strong></div></td>
              <td><div align="center"><strong>Menu Status</strong></div></td>
              <td><div align="center"></div></td>
              <td><div align="center"></div></td>
            </tr>
            <?php do { ?>
              <tr>
                <td><div align="center"><?php echo $row_admin_menu['menu_id']; ?></div></td>
                <td><div align="center"><img src="<?php echo $row_admin_menu['menu_photo']; ?>" height="125px;" width="125px"></div></td>
                <td><div align="center"><?php echo $row_admin_menu['menu_name']; ?></div></td>
                <td><div align="center"><?php echo $row_admin_menu['menu_price']; ?></div></td>
                <td><div align="center"><?php echo $row_admin_menu['menu_status']; ?></div></td>
                <td><div align="center"><a href="admin_update_menu.php?menu_id=<?php echo $row_admin_menu['menu_id']; ?>"><strong>UPDATE</strong></a></div></td>
                <td><div align="center"><a href="admin_delete_menu.php?menu_id=<?php echo $row_admin_menu['menu_id']; ?>"><strong>DELETE</strong></a></div></td>
            </tr>
              <?php } while ($row_admin_menu = mysql_fetch_assoc($admin_menu)); ?>
          </table>
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
    <script type="text/javascript">
// Add the following code if you want the name of the file appear on select
$(".custom-file-input").on("change", function() {
  var fileName = $(this).val().split("\\").pop();
  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});
</script>
</body>
</html>
<?php
mysql_free_result($admin_menu);
?>