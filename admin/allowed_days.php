<!-- Allowed Days -->
		<div class="col">
			<div class="card-title text-center mt-3">
				<h5>Allowed Days</h5>
			</div>
			<div class="card-body">
				<div class="table-responsive">
				<table class="table table-bordered"
				width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>Quantity</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$allowed_day_query= mysqli_query($con,"select * from allowed_days order by allowed_days_id DESC ") or die (mysqli_error());
							while ($row_d= mysqli_fetch_array ($allowed_day_query) ){
							$allowed_days_id=$row_d['allowed_days_id'];
							?>
						<tr>
							<td>
							<input type="hidden" name="allowed_days_id" value="<?php echo $allowed_days_id; ?>">
								<input type="number" name="no_of_days" class="form-control form-control-user"id="exampleInputEmail" aria-describedby="emailHelp" value="<?php echo $row_d['no_of_days']; ?>">
							</td>
							<td>                                
								<button name="no_days" value="no_days" class="btn btn-warning btn-user btn-block"><i class="fa fa-edit">Edit</i>
                                </button>
                            </td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
				</div>
			</div>
		</div>

<?php 
	include ('database/dbcon.php');

		if (isset($_POST['no_days'])) {
			$allowed_days_id = $_POST['allowed_days_id'];
			$no_of_days = $_POST['no_of_days'];

    mysqli_query($con," UPDATE allowed_days SET no_of_days = '$no_of_days' WHERE allowed_days_id = '$allowed_days_id' ")or die(mysqli_error());
    echo "<script>alert('Successfully Updated the Allowed Days!'); window.location='setting.php'</script>";


		}

	?>
