<?php include ('include/header.php');
        include ('database/dbcon.php');
 ?>

 <div class="container-fluid">
<div class="row">
	<div class="col-md-4"></div>
	<div class="col-md-4">
						
<div class="row" style="margin-top:30px;">
	<form method="post">
		<div class="container">	
			<div class="row">
				<div class="col-md-20">
					<label>Scan Member QR Code Here</label>
					<video id="preview" width="100%"></video>
				</div>
				<div>
					<input type="text" name="account_number" id="account_number" hidden>
				</div>
			</div>
		</div>
	</form>

<?php

	if (isset($_POST['account_number'])) {

	$account_number = $_POST['account_number'];

	$sql = mysqli_query($con,"SELECT * FROM user WHERE account_number = '$account_number' ");
	$count = mysqli_num_rows($sql);
	$row = mysqli_fetch_array($sql);
	$user_id = $row['user_id'];

		if($row['account_number'] != $account_number){
			echo "<div class='alert alert-success'>".'No match found'."</div>";
		}else{
			$account_number = $_POST['account_number'];
			echo ('<script> location.href="pending.php?user_id='.$user_id.'";</script');
		}
	}
?>

	</div>
	<div class="col-md-4"></div>
</div>
</div>			


<script>
let scanner = new Instascan.Scanner({ video: document.getElementById('preview')});
Instascan.Camera.getCameras().then(function(cameras){
	if (cameras.length > 0) {
		scanner.start(cameras[0]);
	} else{
		alert('No Cameras Found');
	}
}).catch(function(e){
	console.error(e);
});
scanner.addListener('scan',function(c){
	document.getElementById('account_number').value=c;
	document.forms[0].submit();
});
</script>