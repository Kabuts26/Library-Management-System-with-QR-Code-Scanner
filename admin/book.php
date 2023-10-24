<?php include ('include/header.php');
        include ('database/dbcon.php');
 ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Books</h1>
                        <a href="add_book.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Add Book</a>
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
                                            <th>ISBN</th>
                                            <th>Copies</th>
                                            <th>Category</th>
                                            <th>Status</th>
                                            <th>Remarks</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                            <?php
                            $result= mysqli_query($con,"select * from book order by book_id DESC ") or die (mysqli_error());
                            while ($row= mysqli_fetch_array ($result) ){
                            $id=$row['book_id'];
                            $category_id=$row['category_id'];
                            
                            $cat_query = mysqli_query($con,"select * from category where category_id = '$category_id'")or die(mysqli_error());
                            $cat_row = mysqli_fetch_array($cat_query);
                            ?>
                                    <tr>
                                        <td style="word-wrap: break-word; width: 13em;"><?php echo $row['book_title']; ?></td>
                                        <td style="word-wrap: break-word; width: 10em;"><?php echo $row['author']; ?></td>
                                        <td><?php echo $row['isbn']; ?></td>
                                        <td><?php echo $row['book_copies']; ?></td>
                                        <td><?php echo $cat_row['classname']; ?></td>
                                        <td><?php echo $row['status']; ?></td>
                                        <td><?php echo $row['remarks']; ?></td>
                                        <td>
                                    <a class="btn btn-primary mb-1" href="book.php<?php echo '?book_id='.$id; ?>" data-toggle="modal" data-target="#book<?php echo $id; ?>"> <i class="fa fa-search">View QR Code </i>
                                    <a class="btn btn-warning" href="edit_book.php<?php echo '?book_id='.$id; ?>">
                                    <i class="fa fa-edit">Edit</i>
                                    </a>
                                    </tr>
                                        <!-- Book QRcode Modal -->
                                    <div class="modal fade" id="book<?php  echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content text-center">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-user"></i> <?php echo $row['book_title']; ?></h4>
                                        </div>
                                        <div class="modal-body">
                                            <img src="bookqrcode/<?php echo $row['book_qrcode']; ?>" class="img-thumbnail" width="300px" height="300px">
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                        </td>
                                    
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