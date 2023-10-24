<?php include ('include/header.php');
        include ('database/dbcon.php'); 

    function generateRandomString($length = 25) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
//usage 
$myRandomString = generateRandomString(10);

?>
<div class="row justify-content-center">
<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
    <div class="contatin-fluid">

        <div class="row justify-content-center">

            <div class="col-xl-5 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                            <div class="col-lg-0">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Add User</h1>
                                    </div>
                                    <form class="user" method="post" action="">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" value="<?php echo $myRandomString ?>" name="account_number" 
                                                id="exampleInputEmail" aria-describedby="emailHelp" readonly>
                                        </div>
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
                                            <select name="gender" class="form-select form-control" tabindex="-1" required>
                                            <option value="none" selected disabled hidden>Select Gender</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <select name="user_type" class="form-select form-control" tabindex="-1" required>
                                            <option value="none" selected disabled hidden>Select User Type</option>
                                            <option value="Student">Student</option>
                                            <option value="Teacher">Teacher</option>
                                            <option value="Principal">Principal</option>
                                            </select>
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
                                                id="exampleInputPassword" placeholder="Confirm Your Password">
                                        </div>
                                        <button name="submit" type="submit" class="btn btn-primary btn-user btn-block">
                                            Add User
                                        </button>
                                        <a href="user.php" class="btn btn-warning btn-user btn-block">
                                            Cancel
                                        </a>
                                    </form>
                                </div>
                            </div>
                    </div>
                </div>
    </div>
    </div>
</div>
</div>
<?php
include('phpqrcode/qrlib.php');
if (isset($_POST['submit'])){
    
    $account_number = $_POST['account_number'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $user_type = $_POST['user_type'];
    $contact = $_POST['contact'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // how to save PNG codes to server
    
    $tempDir = "../userqrcode/";

    $codeContents = $account_number;
    
    // we need to generate filename somehow, 
    // with md5 or with database ID used to obtains $codeContents...
    $fileName = $firstname."_".$lastname.'.png';
    

  

    $result=mysqli_query($con,"select * from user WHERE username='$username'") or die (mysqli_error());
    $row=mysqli_num_rows($result);

    if ($row > 0)
    {
    echo "<script>alert('Username already taken!'); window.location='add_user.php'</script>";
    }
    elseif($password != $confirm_password)
    {
    echo "<script>alert('Password do not match!'); window.location='add_user.php'</script>";
    }else
    {
        $pngAbsoluteFilePath = $tempDir.$fileName;
        // generating
        if (file_exists($pngAbsoluteFilePath)) {
            echo '<script>alert(File already generated! We can use this cached file to speed up site on common codes!) window.location="add_user.php"</script>';
            echo '<hr />';

        } else {
        QRcode::png($codeContents, $pngAbsoluteFilePath);

            $urlRelativeFilePath = $tempDir.$fileName;
            mysqli_query($con,"insert into user (account_number, firstname, middlename, lastname, address, email, gender, contact, user_type, user_qrcode, username, password, confirm_password, status, user_added)
            values ('$account_number', '$firstname', '$middlename', '$lastname', '$address', '$email', '$gender', '$contact', '$user_type', '$fileName', '$username', '$password', '$confirm_password', 'Active', NOW())")or die(mysqli_error());
            echo "<script>alert('Account Successfully Added!'); window.location='user.php'</script>";
        }       
    }
    }

    ?>