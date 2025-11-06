<?php 
session_start();
require "connection.php";
$email = "";
$name = "";
$errors = array();


    //if user click continue button in forgot password form
    if(isset($_POST['check-email'])){
        $email = mysqli_real_escape_string($con, $_POST['s_email']);
        $check_email = "SELECT * FROM customer WHERE s_email='$email'";
        $run_sql = mysqli_query($con, $check_email);
        if(mysqli_num_rows($run_sql) > 0){
			$_SESSION['s_email'] = $email;
			echo "<script>
					alert('Email match');
					window.location = 'student_new-password.php';
				  </script>";
            /*$code = rand(999999, 111111);
            $insert_code = "UPDATE customer SET code = $code WHERE s_email = '$email'";
            $run_query =  mysqli_query($con, $insert_code);
            if($run_query){
                $subject = "Password Reset Code";
                $message = "Your password reset code is $code";
                $sender = "From: cafeteriapuo@gmail.com";
                if(mail($email, $subject, $message, $sender)){
                    $info = "We've sent a passwrod reset otp to your email - $email";
                    $_SESSION['info'] = $info;
                    $_SESSION['s_email'] = $email;
                    header('location: student_reset-code.php');
                    exit();
                }else{
                    $errors['otp-error'] = "Failed while sending code!";
                }
            }else{
                $errors['db-error'] = "Something went wrong!";
            }*/
        }else{
			echo "<script>
					alert('Email not exist');
					window.location = 'student_forgot_login.php';
				  </script>";
            //$errors['s_email'] = "This email address does not exist!";
        }
    }

    //if user click check reset otp button
    if(isset($_POST['check-reset-otp'])){
        $_SESSION['info'] = "";
        $otp_code = mysqli_real_escape_string($con, $_POST['otp']);
        $check_code = "SELECT * FROM customer WHERE code = $otp_code";
        $code_res = mysqli_query($con, $check_code);
        if(mysqli_num_rows($code_res) > 0){
            $fetch_data = mysqli_fetch_assoc($code_res);
            $email = $fetch_data['s_email'];
            $_SESSION['s_email'] = $email;
            $info = "Please create a new password that you don't use on any other site.";
            $_SESSION['info'] = $info;
            header('location: student_new-password.php');
            exit();
        }else{
            $errors['otp-error'] = "You've entered incorrect code!";
        }
    }

    //if user click change password button
    if(isset($_POST['change-password'])){
        $_SESSION['info'] = "";
        $s_pass = mysqli_real_escape_string($con, $_POST['s_pass']);
        $c_pass = mysqli_real_escape_string($con, $_POST['c_pass']);
        if($s_pass !== $c_pass){
			echo "<script>
					alert('Confirm password not matched!');
					window.location = 'student_new-password.php';
				  </script>";
            //$errors['s_pass'] = "Confirm password not matched!";
        }else{
            $code = 0;
            $email = $_SESSION['s_email']; //getting this email using session
            $update_pass = "UPDATE customer SET s_pass = '$s_pass' WHERE s_email = '$email'";
            $run_query = mysqli_query($con, $update_pass);
            if($run_query){
                /*$info = "Your password changed. Now you can login with your new password.";
                $_SESSION['info'] = $info;
                header('Location: student_new-password.php');*/
				
				echo "<script>
					alert('Your password changed. Now you can login with your new password');
					window.location = 'student_login.php';
				  </script>";
            }else{
				echo "<script>
					alert('Failed to change your password!');
					window.location = 'student_new-password.php';
				  </script>";
                //$errors['db-error'] = "Failed to change your password!";
            }
        }
    }
    
   //if login now button click
    if(isset($_POST['login-now'])){
        header('Location: login-user.php');
    }
?>