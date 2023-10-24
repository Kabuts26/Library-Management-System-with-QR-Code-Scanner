<?php include ('include/header.php');
        include ('database/dbcon.php');
 ?>

 <div class="container-fluid">
<div class="row">
	<div class="col-md-4"></div>
	<div class="col-md-4">
	
	<form method="post" action="">
<select name="user_id" class="select2_single form-control" required="required" tabindex="-1" >
					<option value="0">Select account ID Number</option>
					<?php
					$result= mysqli_query($con,"select * from user where status = 'Active' ") or die (mysqli_error());
					while ($row= mysqli_fetch_array ($result) ){
					$id=$row['user_id'];
					?>
    <option value="<?php echo $row['user_id']; ?>"><?php echo $row['account_number']; ?> -<?php echo $row['firstname']." ". $row['lastname']; ?></option>
					<?php } ?>
</select>
<br />
<br />
	<button name="submit" type="submit" class="btn btn-primary" style="margin-left:110px;"><i class="glyphicon glyphicon-log-in"></i> Submit</button>
	</form>

<?php

	if (isset($_POST['submit'])) {

	$user_id = $_POST['user_id'];

	$sql = mysqli_query($con,"SELECT * FROM user WHERE user_id = '$user_id' ");
	$count = mysqli_num_rows($sql);
	$row = mysqli_fetch_array($sql);

		if($count <= 0){
			echo "<div class='alert alert-success'>".'No match found for the account ID Number'."</div>";
		}else{
			$user_id = $_POST['user_id'];
			echo ('<script> location.href="borrowed_book.php?user_id='.$user_id.'";</script');
		}
	}
?>

	</div>
	<div class="col-md-4"></div>
</div>
</div>			