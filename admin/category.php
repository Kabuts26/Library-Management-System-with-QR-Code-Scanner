<?php  include('include/header.php'); 
        include('database/dbcon.php');
?>

<div class="row justify-content-center">
<div id="content-wrapper" class="d-flex flex-column">
	<div id="content">
	<div class="contatin-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 ml-5 text-gray-800">Books Categories</h1>
        </div>
     		<div class="card">
     			<div class="row">
     			<div class="col">
	     			<div class="card-body">
	     				<div class="table-responsive">
	     				<table class="table table-bordered" id="dataTable"
				width="100%" cellspacing="0">
	     				<thead>
	     					<tr>
	     						<th>Category</th>
	     						<th>Action</th>
	     					</tr>
	     				</thead>
						<?php
	     					$user_query  = mysqli_query($con,"select * from category")or die(mysqli_error());
							while($cat =mysqli_fetch_array($user_query)){
								$cat_id = $cat['category_id'];
						?>
	     				<form method="post" action="">
	     					<tr>
	     						<td>
	     						<input type="hidden" name="category_id" value="<?php echo $cat_id ?>">
									<input type="text" name="classname" class="form-control form-control-user"id="exampleInputEmail" aria-describedby="emailHelp" value="<?php echo $cat['classname']; ?>">
	     						</td>
	     						<td>                           
									<button name="edit" value="edit" class="btn btn-warning btn-block"><i class="fa fa-edit"></i>
                                	</button>
	     						</td>
	     					</tr>
	     			</form>
	     				<?php }?>
	     				</table>
	     			</div>
	     			</div>
     			</div>
     			<?php 

if (isset($_POST['edit'])) {
	$category_id = $_POST['category_id'];
	$classname = $_POST['classname'];

	mysqli_query($con,"UPDATE category SET classname = '$classname' WHERE category_id = '$category_id'")or die(mysqli_error());
	echo "<script>alert('Successfully Updated!'); window.location='category.php'</script>";
}
?>
     			<?php include('add_category.php'); 
     				  include('include/scripts.php');
     			?>
     			
</div>
</div>
</div>
</div>
</div>
</div>



