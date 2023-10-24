<?php  include('include/header.php'); 
        include('database/dbcon.php');

$user_query  = mysqli_query($con,"select * from user where user_id = '$id_session'")or die(mysqli_error());
$row =mysqli_fetch_array($user_query);
?>
<div class="row justify-content-center">
<div id="content-wrapper" class="d-flex flex-column">
	<div id="content">
	<div class="contatin-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 ml-5 text-gray-800">Personal Information</h1>
            <a href="edit_profile.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mr-5"><i
                    class="fas fa-download fa-sm text-white-50"></i> Edit Profile</a>
        </div>
     		<div class="card">
     			<div class="card-body">
     				<ul>
     					<li>Name: <?php echo $row['firstname']." ".$row['middlename']." ".$row['lastname']; ?></li>
     					<li>Address: <?php echo $row['address']?></li>
     					<li>Contact Number: <?php echo $row['contact']?></li>
     					<li>Email Address: <?php echo $row['email']?></li>
     				</ul>
     			</div>
     		</div>
	</div>
</div>
</div>
</div>
