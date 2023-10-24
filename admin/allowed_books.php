
		<!-- Allowed Book -->
		<div class="col">
			<div class="card-title text-center mt-3">
				<h5>Allowed Books Per Users</h5>
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
					<form method="post" action="">
					<tbody>
						<?php
							$allowed_book_query= mysqli_query($con,"select * from allowed_book order by allowed_book_id DESC ") or die (mysqli_error());
							while ($row_a= mysqli_fetch_array ($allowed_book_query) ){
							$id=$row_a['allowed_book_id'];
							?>
						<tr>
							<td>
							<input type="hidden" name="allowed_book_id" value="<?php echo $id; ?>">
								<input type="number" name="qntty_books" class="form-control form-control-user"id="exampleInputEmail" aria-describedby="emailHelp" value="<?php echo $row_a['qntty_books']; ?>">
							</td>
							<td>                                
								<button name="books" value="books" class="btn btn-warning btn-user btn-block"><i class="fa fa-edit">Edit</i>
                                </button>
                            </td>
						</tr>
					<?php } 
					?>
					</tbody>
				</table>
				</div>
			</div>
		</div>

	<?php 
	include ('database/dbcon.php');

		if (isset($_POST['books'])) {
			$allowed_book_id = $_POST['allowed_book_id'];
			$qntty_books = $_POST['qntty_books'];

    mysqli_query($con," UPDATE allowed_book SET qntty_books = '$qntty_books' WHERE allowed_book_id = '$allowed_book_id' ")or die(mysqli_error());
    echo "<script>alert('Successfully Updated the Allowed Books!'); window.location='setting.php'</script>";


		}

	?>