<?php

    include ('database/dbcon.php');
    $count_penalty = mysqli_query($con,"SELECT sum(book_penalty) FROM return_book WHERE user_id = '$user_id' ")or die(mysqli_error());
    $count_penalty_row = mysqli_fetch_array($count_penalty);

?>
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Pending/Return Books</h1>
                    </div>
                    
                                
                                <div class="pull-left">
                                    <div class="span"><div class="alert alert-info"><i class="icon-credit-card icon-large"></i>&nbsp;Total Amount of Penalty:&nbsp;<?php echo "Php ".$count_penalty_row['sum(book_penalty)'].".00"; ?></div></div>
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
                                            <th>Date Borrowed</th>
                                            <th>Due Date</th>
                                            <th>Penalty</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php 
    $borrow_query = mysqli_query($con,"SELECT * FROM borrow_book
        LEFT JOIN book ON borrow_book.book_id = book.book_id
        LEFT JOIN user ON borrow_book.user_id = user.user_id 
        WHERE borrowed_status = 'borrowed' or borrowed_status = 'pending' ORDER BY borrow_book_id DESC") or die(mysqli_error());
    $borrow_count = mysqli_num_rows($borrow_query);
    while($borrow_row = mysqli_fetch_array($borrow_query)){
        $due_date= $borrow_row['due_date'];
    
    $timezone = "Asia/Manila";
    if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
    $cur_date = date("Y-m-d H:i:s");
    $date_returned = date("Y-m-d H:i:s");
    
        $penalty_amount_query= mysqli_query($con,"select * from penalty order by penalty_id DESC ") or die (mysqli_error());
        $penalty_amount = mysqli_fetch_assoc($penalty_amount_query);
        
        if ($date_returned > $due_date) {
            $penalty = round((float)(strtotime($date_returned) - strtotime($due_date)) / (60 * 60 *24) * ($penalty_amount['penalty_amount']));
        } elseif ($date_returned < $due_date) {
            $penalty = 'No Penalty';
        } else {
            $penalty = 'No Penalty';
        }
?>                                      
                                        <tr>
                                        <td><?php echo $borrow_row['book_title']; ?></td>
                                        <td><?php echo $borrow_row['author']; ?></td>
                                        <td><?php echo date("M d, Y h:m:s a",strtotime($borrow_row['date_borrowed'])); ?></td>
                                        <?php
                                            if ($borrow_row['status'] != 'Hardbound') {
                                                echo "<td>".date('M d, Y h:m:s a',strtotime($borrow_row['due_date']))."</td>";
                                            } else {
                                                echo "<td>".'Hardbound Book, Inside Only'."</td>";
                                            }
                                        ?>
                                    <!---   <td><?php // echo date("M d, Y h:m:s a",strtotime($borrow_row['due_date'])); ?></td>    -->
                                        <?php
                                            if ($borrow_row['status'] != 'Hardbound') {
                                                echo "<td>".$penalty."</td>";
                                            } else {
                                                echo "<td>".'Hardbound Book, Inside Only'."</td>";
                                            }
                                        ?>
                                        <td>
                                <form method="post" action="">
                                <input type="hidden" name="date_returned" class="new_text" id="sd" value="<?php echo $date_returned ?>" size="16" maxlength="10"  />
                                <input type="hidden" name="user_id" value="<?php echo $borrow_row['user_id']; ?>">
                                <input type="hidden" name="borrow_book_id" value="<?php echo $borrow_row['borrow_book_id']; ?>">
                                <input type="hidden" name="book_id" value="<?php echo $borrow_row['book_id']; ?>">
                                <input type="hidden" name="date_borrowed" value="<?php echo $borrow_row['date_borrowed']; ?>">
                                <input type="hidden" name="due_date" value="<?php echo $borrow_row['due_date']; ?>">
                                <?php 
                                if($borrow_row['borrowed_status'] == 'pending'){ 
                                ?>
                                <button name="approve" value="approve" class="btn btn-warning"><i class="glyphicon glyphicon-warning"></i> Approve</button>
                            <?php }else{ ?>
                                <button name="return" value="return" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i> Return</button>
                                        </td>
                            <?php } }?>
                            </form>
                                    </tr>
                            
                                    </tbody>
                                </table>
                            </div>
                        </div>                      
                    </div>
                </div>
                
<?php 
            if (isset($_POST['return'])) {
                $user_id= $_POST['user_id'];
                $borrow_book_id= $_POST['borrow_book_id'];
                $book_id= $_POST['book_id'];
                $date_borrowed= $_POST['date_borrowed'];
                $due_date= $_POST['due_date'];
                $date_returned = $_POST['date_returned'];

                $update_copies = mysqli_query($con,"SELECT * from book where book_id = '$book_id' ") or die (mysqli_error());
                $copies_row= mysqli_fetch_assoc($update_copies);
                
                $book_copies = $copies_row['book_copies'];
                $new_book_copies = $book_copies + 1;
                
                if ($new_book_copies == '0') {
                    $remark = 'Not Available';
                } else {
                    $remark = 'Available';
                }
                
                mysqli_query($con,"UPDATE book SET book_copies = '$new_book_copies' where book_id = '$book_id'") or die (mysqli_error());
                mysqli_query($con,"UPDATE book SET remarks = '$remark' where book_id = '$book_id' ") or die (mysqli_error());
            
                $timezone = "Asia/Manila";
                if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
                $cur_date = date("Y-m-d H:i:s");
                $date_returned_now = date("Y-m-d H:i:s");      
                
                $penalty_amount_query= mysqli_query($con,"select * from penalty order by penalty_id DESC ") or die (mysqli_error());
                $penalty_amount = mysqli_fetch_assoc($penalty_amount_query);
                
                if ($date_returned > $due_date) {
                    $penalty = round((float)(strtotime($date_returned) - strtotime($due_date)) / (60 * 60 *24) * ($penalty_amount['penalty_amount']));
                } elseif ($date_returned < $due_date) {
                    $penalty = 'No Penalty';
                } else {
                    $penalty = 'No Penalty';
                }
            
                mysqli_query($con,"DELETE FROM borrow_book WHERE borrow_book_id = '$borrow_book_id'") or die (mysqli_error());
                
                mysqli_query($con,"INSERT INTO return_book (user_id, book_id, date_borrowed, due_date, date_returned, book_penalty)
                values ('$user_id', '$book_id', '$date_borrowed', '$due_date', '$date_returned', '$penalty')") or die (mysqli_error());
                
                echo "<script>alert('Book Returned Successfully'); window.location='library_system.php?user_id=".$user_id."'</script>";
                         }

            if(isset($_POST['approve'])){

        $date_borrowed = date("Y-m-d H:i:s");
        $borrow_book_id = $_POST['borrow_book_id'];
        mysqli_query($con, "UPDATE borrow_book SET borrowed_status = 'borrowed', date_borrowed ='$date_borrowed' WHERE borrow_book_id = '$borrow_book_id'") or die(mysqli_error());
        echo "<script>alert('Book Successfully Borrowed!'); window.location='library_system.php?user_id=".$user_id."'</script>";
            }

        ?>