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
    $menuArray = $_POST['menu_id'];
    $quantityArray = $_POST['quantity'];
    
    
    foreach ($menuArray as $ind => $menu_id) {
    
   // for ( $ind = 0; $ind < count($menuArray); $ind++ ) {
        
        $insertSQL = sprintf("INSERT INTO ordering (s_matric, menu_id, quantity, `date`, `time`, order_note) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['matric'], "text"),
                       GetSQLValueString($menu_id, "text"),
                       GetSQLValueString($quantityArray[$ind], "int"),
                       GetSQLValueString($_POST['date'], "date"),
                       GetSQLValueString($_POST['time'], "date"),
                       GetSQLValueString($_POST['note'], "text"));

        mysql_select_db($database_cafeteria_system, $cafeteria_system);
        $Result1 = mysql_query($insertSQL, $cafeteria_system) or die(mysql_error());
    }
  
  

  $insertGoTo = "student_order.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>

<?php
    mysql_select_db($database_cafeteria_system, $cafeteria_system);
    $query_Menu = "SELECT menu_id, menu_photo, menu_name, menu_price, menu_status FROM cafeteria WHERE categoryid = 1 ORDER BY menu_id ASC";
    $Menu = mysql_query($query_Menu, $cafeteria_system) or die(mysql_error());
    $row_Menu = mysql_fetch_assoc($Menu);
    $totalRows_Menu = mysql_num_rows($Menu);
    
    $usernameTemp;
    if ( isset($_SESSION['MM_Username']) ) {
        $usernameTemp = $_SESSION['MM_Username'];
    } else {
        $usernameTemp = "";
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
            <form action="<?php echo $editFormAction; ?>" name="form1" method="POST" onSubmit="return ValidationEvent()">
                <h2>Please choose your menu</h2>
                <table class="table-striped w-100" border="0" cellpadding="5">
                    <tr>
                      <td><div align="center"><strong>Action</strong></div></td>
                      <td><div align="center"><strong>Menu ID</strong></div></td>
                      <td><div align="center"><strong>Photo</strong></div></td>
                      <td><div align="center"><strong>Menu Name</strong></div></td>
                      <td><div align="center"><strong>Price</strong></div></td>
                      <td><div align="center"><strong>Quantity</strong></div></td>
                    </tr>
                    <?php 
                        $ind = 0;
                        do { 
                    ?>
                      <tr>
                        <?php 
                            
                            if ( $row_Menu['menu_status'] == 1 ) { 
                        ?>
                            <td>
                                <div align="center">
                                    <input type="checkbox" id="menu_id_<?php echo $ind;?>" name="menu_id[<?php echo $ind;?>]" value="<?php echo $row_Menu['menu_id']; ?>" onClick="calcPrice(<?php echo $ind;?>)" data-id="<?php echo $ind;?>">
                                </div>
                            </td>
                            <td><div align="center"><?php echo $row_Menu['menu_id']; ?></div></td>
                            <td><div align="center"><img src="<?php echo $row_Menu['menu_photo']; ?>" height="125px;" width="125px"></div></td>
                            <td><div align="center"><?php echo $row_Menu['menu_name']; ?></div></td>
                            <td>
                                <div align="center"><?php echo $row_Menu['menu_price']; ?></div>
                                <input type="hidden" id="price_<?php echo $ind;?>" value="<?php echo $row_Menu['menu_price']; ?>">
                            </td>
                            <td>
                                <div align="center">
                                    <input class="form-control" type="number" id="quantity_<?php echo $ind;?>" name="quantity[]" value="0" min="0" max="10" onChange="calcPrice(<?php echo $ind;?>)">
                                </div>
                            </td>
                        <?php
                                $ind++;
                            } else {
                        ?>
                            <td><div align="center">Not Available</div></td>
                            <td><div align="center"><?php echo $row_Menu['menu_id']; ?></div></td>
                            <td><div align="center"><img src="<?php echo $row_Menu['menu_photo']; ?>" height="125px;" width="125px"></div></td>
                            <td><div align="center"><?php echo $row_Menu['menu_name']; ?></div></td>
                            <td><div align="center"><?php echo $row_Menu['menu_price']; ?></div></td>
                            <td><div align="center"></div></td>
                        <?php
                            }
                            
                        ?>
                        
                      </tr>
                      <?php } while ($row_Menu = mysql_fetch_assoc($Menu)); ?>
                </table>
                
                <h2>Please insert your detail</h2>
                <div align="left">Matric Number :</div>
                  <div class="form-group">
                <div align="left"><strong><?php echo $usernameTemp;?></strong></div>
                </div>
                <!--<div align="left">Menu ID :</div>
                <div class="form-group">
                  <input type="text" class="form-control" id="menuID" placeholder="Enter Menu ID" name="menuID" required>
                </div>-->
                <!--<div align="left">Quantity :</div>
                <div class="form-group">
                  <input type="number" class="form-control" id="quantity" placeholder="1-10" name="quantity" required>
                </div>-->
                <div align="left">Date :</div>
                <div class="form-group">
                   <div align="left"><strong><?php date_default_timezone_set("Asia/Kuala_Lumpur");echo date("Y-m-d");?></strong></div>
                </div>
                <div align="left">Time :</div>
                <div class="form-group">
                  <div align="left"><strong><?php echo date("h:i a");?></strong></div>
                </div>
                <div align="left">Order Note :</div>
                <div class="form-group">
                  <input type="text" class="form-control" id="note" placeholder="Please write less than 150 letters." name="note" required>
                </div>
                <div class="form-group">
                  <h2>Total Price : RM <span id="span-total-price">0.00</span></h2>
                </div>
                <br>
                <button type="submit" class="btn btn-default">ORDER</button>
                <input type="hidden" name="MM_insert" value="form1">
                
                <input type="hidden" id="matric" name="matric" value="<?php echo $usernameTemp;?>">
                <input type="hidden" id="date" name="date" value="<?php date_default_timezone_set("Asia/Kuala_Lumpur");echo date("Y-m-d");?>">
                <input type="hidden" id="time" name="time" value="<?php echo date("h:i a");?>">
                
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
        function calcPrice(id) {
            var totalPrice = 0;
            $("input[type='checkbox']").each(function() {
                //console.log($(this).attr("data-id"));
                var dataId = $(this).attr("data-id");
                var checkbox = $("#menu_id_" + dataId);
                var price = $("#price_" + dataId).val();
                var quantity = $("#quantity_" + dataId).val();
                
                if ( checkbox.is(":checked") ) {
                    totalPrice += parseFloat(price) * parseInt(quantity);
                } else {
                    totalPrice -= parseFloat(price) * parseInt(quantity);
                }
                
                $("#span-total-price").html(totalPrice.toFixed(2));
            });
        }

        function ValidationEvent() {
            if ( $("form input[type='checkbox']:checked").length > 0 ) {
                alert("Order has been successfully.");
                return true;
            } else {
                alert ("All fields are required!");
              return false;
            }
        }
    </script>
    
</body>
</html>