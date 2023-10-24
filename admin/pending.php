<?php include ('include/header.php');
        include ('database/dbcon.php');
 ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">All Pending Books</h1>
                    </div>

                    <!-- DataTable Start -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Title</th>
                                            <th>Author</th>
                                            <th>ISBN</th>
                                            <th>Pick Up Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                            
                            <?php
                            $result= mysqli_query($con,"select * from borrow_book left join user  on borrow_book.user_id = user.user_id
                                left join book on borrow_book.book_id = book.book_id where borrowed_status = 'pending' order by borrow_book_id DESC ") or die (mysqli_error());
                            while ($row= mysqli_fetch_array ($result) ){
                            $id=$row['book_id'];
                            $category_id=$row['category_id'];
                            
                            $cat_query = mysqli_query($con,"select * from category where category_id = '$category_id'")or die(mysqli_error());
                            $cat_row = mysqli_fetch_array($cat_query);
                            ?>
                                    <tr>
                                        <td style="word-wrap: break-word; width: 13em;"><?php echo $row['firstname']." ".$row['middlename']." ".$row['lastname']; ?></td>
                                        <td style="word-wrap: break-word; width: 13em;"><?php echo $row['book_title']; ?></td>
                                        <td style="word-wrap: break-word; width: 10em;"><?php echo $row['author']; ?></td>
                                        <td><?php echo $row['isbn']; ?></td>
                                        <td><?php echo $row['date_borrowed']; ?></td>
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