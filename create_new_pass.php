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
                                    
                                    <?php
                                        
                                        $selector = $_GET["selector"]; 
                                        $validator = $_GET["validator"]; 

                                        if (empty($selector) || empty($validator)) {
                                            echo "Could not validate your request!";
                                        } else {
                                            if (ctype_xdigit($selector) !==false && ctype_xdigit($validator) !==false ) {
                                                ?>


                                                <form action ="includes/reset_pass.php" method ="post">
                                                    <input class="form-control mb-3" type = "hidden" name="selector" value ="<?php echo $selector ?>">

                                                    <input class="form-control mb-3" type = "hidden" name="validator" value ="<?php echo $validator ?>">

                                                    <input class="form-control mb-3" type="password" name="pwd" placeholder="Enter your new password"> 

                                                    <input class="form-control mb-3" type="password" name="pwd-repeat" placeholder="Confirm your password"> 

                                                    <button class="btn btn-primary w-100" type ="submit" name="reset-password-submit">Reset Password</button>
                                                </form>


                                                <?php
                                            }
                                        }

                                    ?>

                                    </form>
                                    <?php 
                                        if (isset($_GET["reset"])) {
                                            if ($_GET["reset"] == "success") {
                                                echo '<p class="signupsuccess">Check your email for the link!</p>';
                                            }
                                        }
                                    ?>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="index.php">Back to login...</a>
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