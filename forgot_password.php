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
                                        <h1 class="h4 text-gray-900 mb-4"><b>Reset your password:</b></h1>
                                    </div>
                                    <?php 
                                        if (isset($_GET["reset"])) {
                                            if ($_GET["reset"] == "success") {
                                                echo '<p style="color: #0dba2f; text-align: center">Check your email for the link!</p>';
                                            } elseif ($_GET["reset"] == "emailnotfound") {
                                                echo '<p style="color: red; text-align: center">Email does not exist.</p>';
                                            } else {
                                                echo '<p style="color: red; text-align: center">Something went wrong! Please try again.</p>';
                                            }
                                        }
                                    ?>
                                    <form class="user" method="post" action="includes/reset_request.php">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" name="email" 
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter Email Address" required>
                                        </div>
                                        <button name="reset-request-submit" type="submit" class="btn btn-primary btn-user btn-block">
                                            Send password reset request by by email
                                        </button>
                                    </form>
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