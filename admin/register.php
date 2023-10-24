<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>LMS-Admin</title>

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
                                        <h1 class="h4 text-gray-900 mb-4">Register</h1>
                                    </div>
                                    <form class="user" method="post" action="">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" name="firstname" 
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter First Name" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" name="middlename" 
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter Middle Name" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" name="lastname" 
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter Last Name" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" name="address" 
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter Full Address" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user" name="email" 
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter Email Address" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="tel" class="form-control form-control-user" name="contact" 
                                                id="exampleInputEmail" aria-describedby="emailHelp" pattern="[0-9]{11,11}" maxlength="11"
                                                placeholder="Enter Contact Number" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" name="username" 
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter Username" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" name="password" 
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter Password" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" name="confirm_password" 
                                                id="exampleInputPassword" placeholder="Confirm Your Password" required>
                                        </div>
                                        <button name="submit" type="submit" class="btn btn-primary btn-user btn-block">
                                            Sign Up
                                        </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="index.php">Already have an account?</a>
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
</body>

</html>

<?php
include ('database/dbcon.php');
if (isset($_POST['submit'])){
    
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    $result=mysqli_query($con,"select * from admin WHERE username='$username' ") or die (mysqli_error());
    $row=mysqli_num_rows($result);

    if ($row > 0)
    {
    echo "<script>alert('Username already taken!'); window.location='register.php'</script>";
    }
    elseif($password != $confirm_password)
    {
    echo "<script>alert('Password do not match!'); window.location='register.php'</script>";
    }else
    {       
        mysqli_query($con,"insert into admin (firstname, middlename, lastname,  username, address, email, contact, password, confirm_password, admin_added)
        values ('$firstname', '$middlename', '$lastname', '$address', '$email', '$contact', '$username', '$password', '$confirm_password', NOW())")or die(mysqli_error());
        echo "<script>alert('Account successfully added!'); window.location='index.php'</script>";
    }

    }

    ?>
