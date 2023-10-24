<?php include ('include/header.php'); 
    include ('database/dbcon.php');
    $where ="";
    $user_id = $_GET['user_id'];
    if(isset($_GET['search'])){
        $where = " and (date(borrow_book.date_borrowed) between '".date("Y-m-d",strtotime($_GET['datefrom']))."' and '".date("Y-m-d",strtotime($_GET['dateto']))."' ) ";
    }
    
    $return_query= mysqli_query($con,"SELECT * from borrow_book 
    LEFT JOIN book ON borrow_book.book_id = book.book_id 
    LEFT JOIN user ON borrow_book.user_id = user.user_id 
    where borrow_book.borrowed_status = 'borrowed' and user.user_id = '$user_id' $where order by borrow_book.borrow_book_id DESC") or die (mysqli_error());
        $return_count = mysqli_num_rows($return_query);
                
$sql = mysqli_query($con,"SELECT * FROM user WHERE user_id = '$user_id' ");
$row = mysqli_fetch_array($sql);
                   
    
?>

                <!-- Begin Page Content -->
                <div class="container-fluid">
                <div class="card">
            <div class="card-header mb-3 pt-0">    
                <h1 class="h3 ml-5 mt-3 mb-0 text-gray-800" style="word-wrap: break-word; width: 17em;" >Account Name: <?php echo $row['firstname']." ".$row['lastname']; ?></h1>
                            
                        </div>

                    <?php include('return_book.php'); ?>


                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Borrowed Books</h1>
                    </div>
        <div class="card">
        <div class="card-header">
                            <label>Scan Book QR Code Here</label>
        </div>
        <div class="card-body">        
            <form method="post">
                <div class="container"> 
                    <div class="row">
                        <div class="col-md-10">
                            <video id="preview" width="35%"></video>
                        </div>
                        <div>
                            <input type="text" name="barcode" id="barcode" hidden>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        </div>
                    <!-- DataTable Start -->
                    <div class="card shadow mb-4">
                        
                        <div class="card-body">
                            <div class="table-responsive">
                                    <form method="post" action="">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Author</th>
                                            <th>Category</th>
                                            <th>Status</th>
                                            <th>Copies</th>
                                            <th>Action</th>
                                        </tr>
                            <?php 

                                if (isset($_POST['barcode'])){
                                    $barcode = $_POST['barcode'];
                                    
                                    $book_query = mysqli_query($con,"SELECT * FROM book WHERE book_barcode = '$barcode' ") or die (mysqli_error());
                                    $book_count = mysqli_num_rows($book_query);
                                    $book_row = mysqli_fetch_array($book_query);


                            $category_id=$book_row['category_id'];
                            
                            $cat_query = mysqli_query($con,"select * from category where category_id = '$category_id'")or die(mysqli_error());
                            $cat_row = mysqli_fetch_array($cat_query);
                                    
                                    if ($book_row['book_barcode'] != $barcode){
                                        echo '
                                            <table>
                                                <tr>
                                                    <td class="alert alert-info">No match for the barcode entered!</td>
                                                </tr>
                                            </table>
                                        ';
                                    } elseif ($barcode == '') {
                                        echo '
                                            <table>
                                                <tr>
                                                    <td class="alert alert-info">Enter the correct details!</td>
                                                </tr>
                                            </table>
                                        ';
                                    }else{
                            ?>
                                    </thead>
                                    <tbody>
                                        <tr>
                            <input type="hidden" name="user_id" value="<?php echo $row['user_id'] ?>">
                            <input type="hidden" name="book_id" value="<?php echo $book_row['book_id'] ?>">
                                        <td style="word-wrap: break-word; width: 17em;"><?php echo $book_row['book_title']; ?></td>
                                        <td><?php echo $book_row['author']; ?></td>
                                        <td><?php echo $cat_row['classname']; ?></td>
                                        <td><?php echo $book_row['status']; ?></td>
                                        <td><?php echo $book_row['book_copies']; ?></td>
                                        <td>
                                <button name="submit" value="submit" class="btn btn-success"> Borrow</button></td>
                                    </tr>
                                <?php  } }?>
                            <?php
                            
                            $allowable_days_query= mysqli_query($con,"select * from allowed_days order by allowed_days_id DESC ") or die (mysqli_error());
                            $allowable_days_row = mysqli_fetch_assoc($allowable_days_query);
                            
                            $timezone = "Asia/Manila";
                            if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
                            $cur_date = date("Y-m-d H:i:s");
                            $date_borrowed = date("Y-m-d H:i:s");
                            $due_date = strtotime($cur_date);
                            $due_date = strtotime("+".$allowable_days_row['no_of_days']." day", $due_date);
                            $due_date = date('Y-m-d H:i:s', $due_date);
                            ?>
                            <input type="hidden" name="due_date" class="new_text" id="sd" value="<?php echo $due_date ?>" size="16" maxlength="10"  />
                            <input type="hidden" name="date_borrowed" class="new_text" id="sd" value="<?php echo $date_borrowed ?>" size="16" maxlength="10"  />
                            
                            
                                    </tbody>
                                </table>
                                </form>
                            </div>
                        </div>                      
                    </div>

            <!-- End of Main Content -->
        </div>
    </div>
</div>
    <?php 
                                if (isset($_POST['submit'])){
                                    $user_id =$_POST['user_id'];
                                    $book_id =$_POST['book_id'];
                                    $date_borrowed =$_POST['date_borrowed'];
                                    $due_date =$_POST['due_date'];
                                    
                                    $trapBookCount= mysqli_query($con,"SELECT count(*) as books_allowed from borrow_book where user_id = '$user_id' and borrowed_status = 'borrowed'") or die (mysqli_error());
                                    
                                    $countBorrowed = mysqli_fetch_assoc($trapBookCount);
                                    
                                    $bookCountQuery= mysqli_query($con,"SELECT count(*) as book_count from borrow_book where user_id = '$user_id' and borrowed_status = 'borrowed' and book_id = $book_id") or die (mysqli_error());
                                    
                                    $bookCount = mysqli_fetch_assoc($bookCountQuery);
                                    
                                    $allowed_book_query= mysqli_query($con,"select * from allowed_book order by allowed_book_id DESC ") or die (mysqli_error());
                                    $allowed = mysqli_fetch_assoc($allowed_book_query);
                                    
                                    if ($countBorrowed['books_allowed'] == $allowed['qntty_books']){
                                        echo "<script>alert(' ".$allowed['qntty_books']." ".'Books Allowed per User!'." '); window.location='borrowed_book.php?user_id=".$user_id."'</script>";
                                    }elseif ($bookCount['book_count'] == 1){
                                        echo "<script>alert('Book Already Borrowed!'); window.location='borrowed_book.php?user_id=".$user_id."'</script>";
                                    }else{
                                        
                                    $update_copies = mysqli_query($con,"SELECT * from book where book_id = '$book_id' ") or die (mysqli_error());
                                    $copies_row= mysqli_fetch_assoc($update_copies);
                                    
                                    $book_copies = $copies_row['book_copies'];
                                    $new_book_copies = $book_copies - 1;
                                    
                                    if ($new_book_copies < 0){
                                        echo "<script>alert('Book out of Copy!'); window.location='borrow_book.php?user_id=".$user_id."'</script>";
                                    }elseif ($copies_row['status'] == 'Damaged'){
                                        echo "<script>alert('Book Cannot Borrow At This Moment!'); window.location='borrowed_book.php?user_id=".$user_id."'</script>";
                                    }elseif ($copies_row['status'] == 'Lost'){
                                        echo "<script>alert('Book Cannot Borrow At This Moment!'); window.location='borrowed_book.php?user_id=".$user_id."'</script>";
                                    }else{
                                        
                                    if ($new_book_copies == '0') {
                                        $remark = 'Not Available';
                                    } else {
                                        $remark = 'Available';
                                    }
                                    
                                    mysqli_query($con,"UPDATE book SET book_copies = '$new_book_copies' where book_id = '$book_id' ") or die (mysqli_error());
                                    mysqli_query($con,"UPDATE book SET remarks = '$remark' where book_id = '$book_id' ") or die (mysqli_error());
                                    
                                    mysqli_query($con,"INSERT INTO borrow_book(user_id,book_id,date_borrowed,due_date,borrowed_status)
                                    VALUES('$user_id','$book_id','$date_borrowed','$due_date','borrowed')") or die (mysqli_error());
                                    
                                    $report_history=mysqli_query($con,"select * from admin where admin_id = $id_session ") or die (mysqli_error());
                                    $report_history_row=mysqli_fetch_array($report_history);
                                    $admin_row=$report_history_row['firstname']." ".$report_history_row['middlename']." ".$report_history_row['lastname'];  
                                    
                                    mysqli_query($con,"INSERT INTO report 
                                    (book_id, user_id, admin_name, detail_action, date_transaction)
                                    VALUES ('$book_id','$user_id','$admin_row','Borrowed Book',NOW())") or die(mysqli_error());
                                    
                                    }
                                    }
                                    echo "<script>alert('Book Successfully Borrowed!'); window.location='library_system.php?user_id=".$user_id."'</script>";
     
                                }
                            ?>

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

<script>
let scanner = new Instascan.Scanner({ video: document.getElementById('preview')});
Instascan.Camera.getCameras().then(function(cameras){
    if (cameras.length > 0) {
        scanner.start(cameras[0]);
    } else{
        alert('No Cameras Found');
    }
}).catch(function(e){
    console.error(e);
});
scanner.addListener('scan',function(c){
    document.getElementById('barcode').value=c;
    document.forms[0].submit();
});
</script>