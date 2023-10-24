<?php include ('include/header.php'); 
    include ('database/dbcon.php');

$query=mysqli_query($con,"select * from user where user_id='$id_session'")or die(mysqli_error());
$row=mysqli_fetch_array($query);
$old_pass = $row['password']
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
                                        <h1 class="h4 text-gray-900 mb-4">Edit Username/Password</h1>
                                    </div>
                                    <form class="user" method="post" action="">
                                        <div class="form-group">
                                            <input type="text" name="username" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp" value="<?php echo $row['username']; ?>"
                                                placeholder="Enter Username">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="old_pass" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp" value=""
                                                placeholder="Enter Your Old Password">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="new_pass" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter Your New Passowrd">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="confirm_pass" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Confirm Password">
                                        </div>
                                        <button type="submit" name="submit" class="btn btn-primary btn-user btn-block">
                                            Update
                                        </button>
                                        <a href="home.php" class="btn btn-warning btn-user btn-block">
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
    if(isset($_POST['submit'])){

$username = $_POST['username'];
$password = $_POST['old_pass'];
$new_password = $_POST['new_pass'];
$confirm_password = $_POST['confirm_pass'];

if ($old_pass != $password) {
    echo "<script>alert('Old Password do not match!'); window.location='edit_pass.php'</script>";
}
else{
    if($new_password != $confirm_password){
    echo "<script>alert('New Password do not match to Confirm Password!'); window.location='edit_pass.php'</script>";
    }else{       
        mysqli_query($con," UPDATE user SET username='$username', password='$new_password', 
        confirm_password='$confirm_password' WHERE user_id = '$id_session' ")or die(mysqli_error());
        echo "<script>alert('Successfully Updated the Password!'); window.location='home.php'</script>";
    }
    }
}
?>