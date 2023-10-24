<!-- Penalty -->
		<div class="col">
			<div class="card-title text-center mt-3">
				<h5>Penalty Per Day</h5>
			</div>
			<div class="card-body">
				<div class="table-responsive">
				<table class="table table-bordered"
				width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>Amount(Php)</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$penalty_query= mysqli_query($con,"select * from penalty order by penalty_id DESC ") or die (mysqli_error());
							while ($row_p= mysqli_fetch_array ($penalty_query) ){
							$penalty_id=$row_p['penalty_id'];
							?>
						<tr>
							<td>
							<input type="hidden" name="penalty_id" value="<?php echo $penalty_id; ?>">
								<input type="number" name="penalty_amount" class="form-control form-control-user"id="exampleInputEmail" aria-describedby="emailHelp" value="<?php echo $row_p['penalty_amount']; ?>">
							</td>
							<td>                                
								<button name="penalty" value="penalty" class="btn btn-warning btn-user btn-block"><i class="fa fa-edit">Edit</i>
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

		if (isset($_POST['penalty'])) {
			$penalty_id = $_POST['penalty_id'];
			$penalty_amount = $_POST['penalty_amount'];

    mysqli_query($con," UPDATE penalty SET penalty_amount = '$penalty_amount' WHERE penalty_id = '$penalty_id' ")or die(mysqli_error());
    echo "<script>alert('Successfully Updated the Penalty!'); window.location='setting.php'</script>";


		}

	?>