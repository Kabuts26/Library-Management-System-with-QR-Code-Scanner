<?php include ('include/header.php'); 
    include ('database/dbcon.php');

$count1 = mysqli_fetch_array(mysqli_query($con,"SELECT COUNT(*) as total FROM `borrow_book` WHERE `borrowed_status` = 'borrowed' and user_id = '$id_session'")) or die(mysqli_error());
$count2 = mysqli_fetch_array(mysqli_query($con,"SELECT COUNT(*) as total FROM `borrow_book` WHERE `borrowed_status` = 'pending' and user_id = '$id_session'")) or die(mysqli_error());
    
$count_penalty = mysqli_query($con,"SELECT sum(book_penalty) FROM return_book ")or die(mysqli_error());
$count_penalty_row = mysqli_fetch_array($count_penalty);
?>

                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-5 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Pending Books</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $count2['total']; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-book fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-5 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Borrowed Books</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $count1['total']; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-book fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                Penalty Fee &nbsp; </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"> &nbsp; <?php echo "Php ".$count_penalty_row['sum(book_penalty)'].".00"; ?></div>
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

                        <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Borrowed Books</h1>
                    </div>

                    <!-- DataTable Start -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Author</th>
                                            <th>Pick up Date</th>
                                            <th>Return Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                            <?php
                                $borrow_query = mysqli_query($con,"SELECT * FROM borrow_book
                                    LEFT JOIN book ON borrow_book.book_id = book.book_id 
                                    LEFT JOIN user ON borrow_book.user_id = user.user_id 
                                    WHERE borrowed_status = 'borrowed' or borrowed_status = 'pending' or borrowed_status = 'overdue' and user.user_id = '$id_session'
                                    ORDER BY borrow_book.borrow_book_id DESC") or die(mysqli_error());
                                $borrow_count = mysqli_num_rows($borrow_query);
                                while($borrow_row = mysqli_fetch_array($borrow_query)){
                                    $id = $borrow_row ['borrow_book_id'];
                                    $book_id = $borrow_row ['book_id'];
                                    $user_id = $borrow_row ['user_id'];
                            ?>
                                            <tr>
                                            <td><?php echo $borrow_row['book_title']; ?></td>
                                            <td><?php echo $borrow_row['author']; ?></td>
                                            <td><?php echo date("M d, Y h:m:s a",strtotime($borrow_row['date_borrowed'])); ?></td>
                                            <?php 

                                            if ($borrow_row['borrowed_status'] == 'pending') {
                                                echo"<td></td>";
                                            }else{
                                                echo"<td>".date("M d, Y h:m:s a",strtotime($borrow_row['due_date']))."</td>";
                                            }

                                            ?>
                                            <td><?php echo $borrow_row['borrowed_status']; ?>
                                            </td>
                                            <?php 

                                            if ($borrow_row['borrowed_status'] == 'borrowed') {
                                                echo"<td></td>";
                                            }else{ ?>
                                            <td>
                                                <a class="btn btn-warning" for="DeleteAdmin" href="#cancel<?php echo $id; ?>" data-toggle="modal" data-target="#cancel<?php echo $id; ?>">
                                                        <i class="fa fa-cancel icon-cancel">Cancel</i>
                                                    </a>

                                    <!-- Cancel Book Request -->
                                    <div class="modal fade" id="cancel<?php  echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-user"></i> User</h4>
                                        </div>
                                        <div class="modal-body">
                                                <div class="alert alert-danger">
                                                    Are you sure you want to cancel?
                                                </div>
                                                <div class="modal-footer">
                                                <button class="btn btn-inverse" data-dismiss="modal" aria-hidden="true"><i class="glyphicon glyphicon-remove icon-white"></i> No</button>
                                                <a href="cancel.php<?php echo '?borrow_book_id='.$id; ?>" style="margin-bottom:5px;" class="btn btn-primary"><i class="glyphicon glyphicon-ok icon-white"></i> Yes</a>
                                                </div>
                                        </div>
                                        </div>
                                    </div>
                                    </div><?php } ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>                      
                    </div>
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

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

</body>

</html>