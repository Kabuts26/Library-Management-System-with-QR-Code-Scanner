<div class="col">
					<div class="card-title text-center mt-3">
						<h5>Add Categories</h5>
					</div>
					<div class="card-body">
						<div class="table-responsive">
						<form method="post" action="">
						<div class="form-group">
								<input type="text" name="classname" class="form-control form-control-user"id="exampleInputEmail" aria-describedby="emailHelp" value="" placeholder="Enter a Category" required>        
						</div>                   
								<button name="add" value="add" class="btn btn-primary btn-user btn-block"><i class="fa fa-plus"> Add</i>
                                </button>
                         </form>

     			</div>
     		</div>
		</div>

<?php

	if (isset($_POST['add'])) {
		$classname = $_POST['classname'];

		mysqli_query($con,"INSERT INTO category (classname) VALUES ('$classname')")or die(mysqli_error());
        echo "<script>alert('Successfully Added the Category!'); window.location='category.php'</script>";
	}

?>