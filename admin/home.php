<?php include ('include/header.php'); 
    include ('database/dbcon.php');

$users = mysqli_fetch_array(mysqli_query($con,"SELECT COUNT(*) as total FROM `user` WHERE `status` = 'Active'")) or die(mysqli_error());

$count1 = mysqli_fetch_array(mysqli_query($con,"SELECT COUNT(*) as total FROM `borrow_book` WHERE `borrowed_status` = 'borrowed'")) or die(mysqli_error());

$req = mysqli_fetch_array(mysqli_query($con,"SELECT COUNT(*) as total FROM `borrow_book` WHERE `borrowed_status` = 'pending'")) or die(mysqli_error());

$books = mysqli_fetch_array(mysqli_query($con,"SELECT COUNT(*) as total FROM book")) or die(mysqli_error());

 ?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Registered Users -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Registered Users</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $users['total']; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Books -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Total Books</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $books['total']; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-book fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Books -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending Books
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $req['total']; ?></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-book fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Borrowed Books -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Borrowed Books
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $count1['total']; ?></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-book fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                        <!-- Content Row -->
                    <div class="row">

                            <!-- Line Chart -->
                            <?php include ('line.php'); ?>

                            <!-- Pie Chart -->
                            <?php include ('pie.php'); ?>

                            <!-- Bar Chart -->
                            <?php include ('chart.php'); ?>


                        </div>

                    <!-- Content Row 

                    <div class="row">

                        <div class="col">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Transaction History (Borrowed Books)</h5>
                                    <table class="table table-bordered" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Title of the Book</th>
                                                <th>Name of the Borrower</th>
                                                <th>Date Transaction</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                    <?php 
                    $query = mysqli_query($con,"SELECT * FROM borrow_book 
                                    LEFT JOIN book ON borrow_book.book_id = book.book_id 
                                    LEFT JOIN user ON borrow_book.user_id = user.user_id  where borrowed_status = 'borrowed'");
                    while($row = mysqli_fetch_array($query)){
                    ?>
                                            <tr>
                                                <td><?php echo $row['book_title']; ?></td>
                                                <td><?php echo $row['firstname']." ".$row['middlename']." ".$row['lastname']; ?></td>
                                                <td><?php echo $row['date_borrowed']; ?></td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Transaction History (Returned Books)</h5>
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Title of the Book</th>
                                                <th>Name of the Borrower</th>
                                                <th>Date Transaction</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                    <?php 
                    $query = mysqli_query($con,"SELECT * FROM borrow_book 
                                    LEFT JOIN book ON borrow_book.book_id = book.book_id 
                                    LEFT JOIN user ON borrow_book.user_id = user.user_id  where borrowed_status = 'returned'");
                    while($row = mysqli_fetch_array($query)){
                    ?>
                                            <tr>
                                                <td><?php echo $row['book_title']; ?></td>
                                                <td><?php echo $row['firstname']." ".$row['middlename']." ".$row['lastname']; ?></td>
                                                <td><?php echo $row['date_borrowed']; ?></td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>-->

            </div>
            <!-- End of Main Content -->
        </div>
    </div>

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>



</body>

</html>