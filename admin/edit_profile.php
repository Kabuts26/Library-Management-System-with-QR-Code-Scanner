<?php include ('include/header.php'); 
        include ('database/dbcon.php');


  $query=mysqli_query($con,"select * from user where user_id= '$id_session'")or die(mysqli_error());
$row=mysqli_fetch_array($query);
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
                                        <h1 class="h4 text-gray-900 mb-4">Edit Profile</h1>
                                    </div>
                                    <form class="user" method="post" action="">
                                        <div class="form-group">
                                            <input type="text" name="firstname" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp" value="<?php echo $row['firstname']; ?>" 
                                                placeholder="Enter First Name">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="middlename" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp" value="<?php echo $row['middlename']; ?>" 
                                                placeholder="Enter Middle Name">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="lastname" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp" value="<?php echo $row['lastname']; ?>" 
                                                placeholder="Enter Last Name">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="address" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp" value="<?php echo $row['address']; ?>" 
                                                placeholder="Enter Full Address">
                                        </div>
                                        <div class="form-group">
                                            <input type="tel" name="contact" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" value="<?php echo $row['contact']; ?>" name="contact" id="last-name2"  pattern="[0-9]{11,11}" maxlength="11" placeholder="Enter Contact Number">
                                        </div>
                                        <div class="form-group">
                                            <input type="email" name="email" class="form-control form-control-user"id="exampleInputEmail" aria-describedby="emailHelp" value="<?php echo $row['email']; ?>"placeholder="Enter Email Address">
                                        </div>
                                        <button name="submit" value="submit" class="btn btn-primary btn-user btn-block">
                                            Update
                                        </button>
                                        <a href="profile.php" class="btn btn-warning btn-user btn-block">
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

</body>

</html>

<?php 
    if (isset($_POST['submit'])) {
                          
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];

    $result=mysqli_query($con,"select * from admin") or die (mysqli_error());
    $row=mysqli_num_rows($result);

    mysqli_query($con," UPDATE admin SET firstname='$firstname', middlename='$middlename', lastname='$lastname', address='$address',  email='$email',  contact='$contact' WHERE admin_id = '$id_session' ")or die(mysqli_error());
    echo "<script>alert('Successfully Update Admin Info!'); window.location='profile.php'</script>";
    }
?>