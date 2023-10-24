<?php 
    include ('include/header.php');
    include ('database/dbcon.php')
?>
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Montly Report</h1>
                    </div>

                    <!-- DataTable Start -->
                    <div class="card shadow mb-4">
                        <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs">
                          <li class="nav-item">
                            <a class="nav-link" href="report.php">All</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link active" href="month_report.php">Montly</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="quarter_report.php">Quarterly</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="year_report.php">Yearly</a>
                          </li>
                        </ul>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Borrower Name</th>
                                            <th>Title</th>
                                            <th>Date Returned</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                        <?php 
                                        $result= mysqli_query($con,"select * from return_book 
                                    LEFT JOIN book ON return_book.book_id = book.book_id 
                                    LEFT JOIN user ON return_book.user_id = user.user_id WHERE
                                    MONTH(date_returned) = MONTH(CURDATE())
                                    order by return_book.return_book_id DESC ") or die (mysqli_error());
                                    while ($row= mysqli_fetch_array ($result) ){
                                        $id=$row['return_book_id'];
                                        $book_id=$row['book_id'];
                        ?>
                                        <tr>
                                <form method="post" action="">
                                        <td>
                                            <input type="hidden" name="return_book_id" value="<?php echo $row['return_book_id']; ?>">
                                            <?php echo $row['firstname']." ".$row['middlename']." ".$row['lastname']; ?>
                                        </td>
                                        <td><?php echo $row['book_title'];?></td>
                                        <td><?php echo $row['date_returned'];?></td>
                                        <td>
                                <button name="submit" value="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
                                        </td>
                                </form>
                                    </tr>
                                <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>                      
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

    <?php 

    if (isset($_POST['submit'])) {
        $return_book_id = $_POST['return_book_id'];

        mysqli_query($con,"DELETE FROM return_book WHERE return_book_id = '$return_book_id' ")or die(mysqli_error());

        echo "<script>alert('Successfully Deleted the Record!'); window.location='report.php'</script>";
    }
?>