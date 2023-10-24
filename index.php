<?php
require_once('PHPMailer/src/PHPMailer.php');
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Library Management System</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-5 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                            <div class="col-lg-0">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4"><b>Library Management System</b></h1>
                                    </div>
                                    <?php 
                                        if (isset($_GET["newpwd"])) {
                                            if ($_GET["newpwd"] == "passwordupdated") {
                                                echo '<p style="color: #0dba2f; text-align: center">Your password has been reset!</p>';
                                            }
                                        }
                                        ?>
                                    <form class="user" method="post" action="">
                                    <?php 
                                        if (isset($_GET["accessdenied"])) {
                                            if ($_GET["accessdenied"] == "invalid") {
                                                echo '<div class="alert alert-danger">
                                                Invalid username or password!
                                              </div>';
                                            }
                                        }
                                        ?>
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" name="username" 
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter Username" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" name="password" 
                                                id="exampleInputPassword" placeholder="Enter Password" required>
                                        </div>
                                        
                                        <button name="submit" type="submit" class="btn btn-primary btn-user btn-block">
                                            Login
                                        </button>
                                    </form>
                                    <hr><div class="text-center">
                                        <a class="small" href="forgot_password.php">Forgot password?</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="register.php">Don't have an account? Sign up!</a>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>


 <?php
include('database/dbcon.php');

if (isset($_POST['submit'])){

$username=$_POST['username'];
$password=$_POST['password'];

$login_query=mysqli_query($con,"select * from user where username='$username' and password='$password'");
$count=mysqli_num_rows($login_query);
$row=mysqli_fetch_array($login_query);

if ($count > 0){
session_start();
$_SESSION['id']=$row['user_id'];

    if($row["user_type"]=="Admin"){
        echo "<script>window.location='admin/home.php'</script>";
    }

    else{
        echo "<script>window.location='home.php'</script>";
    }

}else{ 
    header("Location:index.php?accessdenied=invalid");  
}
}
?>

</body>

</html>