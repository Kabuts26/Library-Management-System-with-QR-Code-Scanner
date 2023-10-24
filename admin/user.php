<?php include ('include/header.php'); 
    include ('database/dbcon.php');
?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Users</h1>
                        <a href="add_user.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Add Users</a>
                    </div>

                    <!-- DataTable Start -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                        <th>Member Name</th>
                                        <th>Email Account</th>
                                        <th>Contact Number</th>
                                        <th>Address</th>
                                        <th>User Type</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                            <?php
                            $result= mysqli_query($con,"select * from user WHERE NOT user_type = 'Admin' order by user_id DESC") or die (mysqli_error());
                            while ($row= mysqli_fetch_array ($result) ){
                                $id=$row['user_id'];
                            ?>
                            <tr>
                                        <td><?php echo $row['firstname']." ".$row['middlename']." ".$row['lastname']; ?></td>
                                        <td><?php echo $row['email']; ?></td>
                                        <td><?php echo $row['contact']; ?></td>
                                        <td><?php echo $row['address']; ?></td>
                                        <td><?php echo $row['user_type']; ?></td>
                                        <td><?php echo $row['status']; ?></td>
                                        <td>
                                    <a class="btn btn-primary" href="user_profile.php<?php echo '?user_id='.$id; ?>">
                                        <i class="fa fa-search"></i>
                                    </a>
                                <a class="btn btn-danger" for="DeleteAdmin" href="#delete<?php echo $id; ?>" data-toggle="modal" data-target="#delete<?php echo $id; ?>">
                                        <i class="fa fa-trash icon-white"></i>
                                    </a>
                                
            
                                    <!-- delete modal user -->
                                    <div class="modal fade" id="delete<?php  echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-user"></i> User</h4>
                                        </div>
                                        <div class="modal-body">
                                                <div class="alert alert-danger">
                                                    Are you sure you want to delete?
                                                </div>
                                                <div class="modal-footer">
                                                <button class="btn btn-inverse" data-dismiss="modal" aria-hidden="true"><i class="glyphicon glyphicon-remove icon-white"></i> No</button>
                                                <a href="delete_user.php<?php echo '?user_id='.$id; ?>" style="margin-bottom:5px;" class="btn btn-primary"><i class="glyphicon glyphicon-ok icon-white"></i> Yes</a>
                                                </div>
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                        </td>
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