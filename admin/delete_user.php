<?php 

include('database/dbcon.php');

$get_id=$_GET['user_id'];

mysqli_query($con,"DELETE FROM user WHERE user_id = '$get_id' ")or die(mysqli_error());

header('location:user.php');
?>