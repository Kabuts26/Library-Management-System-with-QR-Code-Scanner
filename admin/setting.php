<?php
	include ('include/header.php');
?>

<div class="container-fluid">

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Setting</h1>
    <!-- <a href="add_user.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-download fa-sm text-white-50"></i> Add Users</a> -->
</div>

<div class="card">
	<div class="row">
		<?php include('allowed_books.php'); ?>

		<?php include ('penalty.php'); ?>

		<?php include ('allowed_days.php'); ?>
		
	</div>
</div>

</div>