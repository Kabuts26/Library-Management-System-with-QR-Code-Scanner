<?php include ('include/header.php');
        include ('database/dbcon.php');

 ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Books</h1>
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
                                            <th>Copies</th>
                                            <th>Category</th>
                                            <th>Status</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                            <?php
                            $result= mysqli_query($con,"SELECT * from book order by book_id DESC ") or die (mysqli_error());
                            while ($row= mysqli_fetch_array ($result) ){
                            $id=$row['book_id'];
                            $category_id=$row['category_id'];
                            
                            $cat_query = mysqli_query($con,"SELECT * from category where category_id = '$category_id'")or die(mysqli_error());
                            $cat_row = mysqli_fetch_array($cat_query);
                            ?>
                                    <tr>
                                        <td style="word-wrap: break-word; width: 17em;"><?php echo $row['book_title']; ?></td>
                                        <td style="word-wrap: break-word; width: 15em;"><?php echo $row['author']; ?></td>
                                        <td><?php echo $row['book_copies']; ?></td>
                                        <td><?php echo $cat_row['classname']; ?></td>
                                        <td><?php echo $row['status']; ?></td>
                                        <td><?php echo $row['remarks']; ?></td>
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