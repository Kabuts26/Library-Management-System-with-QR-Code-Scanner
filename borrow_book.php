<?php include ('include/header.php'); 
$user_id = $id_session;

$query = mysqli_fetch_array(mysqli_query($con, "SELECT COUNT(*) as total FROM borrow_book WHERE user_id = '$user_id'"));

$count = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM allowed_book"));
?>



		<!-- Begin Page Content -->
                <div class="container-fluid">

                    <form method="post" action="">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    </div>

                    <div class="pull-left">
                                    <div class="span"><div class="alert alert-info"><i class="icon-credit-card icon-large"></i>Total Book You Borrow/Request: <?php echo $query['total'];?>, Limit is <?php echo $count['qntty_books']; ?></div></div>
                                </div>

                    <!-- DataTable Start -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-6">
                        <label>Select Date of Pick Up</label>
                        <input type="date" name="borrow_date" class="form-control" id="exampleInputEmail" aria-describedby="emailHelp" required>
                    </div>
                                <div class="col-6">
                                        <button name="borrow" class="btn btn-primary btn-user btn-block">
                                            Request
                                        </button>
                                    </div>
                                    </div>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Title</th>
                                            <th>Author</th>
                                            <th>Category</th>
                                            <th>Status</th>
                                            <th>Copies</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                            <?php
                            $result= mysqli_query($con,"SELECT * from book where remarks = 'Available' order by book_id ASC ") or die (mysqli_error());
                            while ($row= mysqli_fetch_array ($result) ){
                            $id=$row['book_id'];
                            $category_id=$row['category_id'];
                            
                            $cat_query = mysqli_query($con,"SELECT * from category where category_id = '$category_id'")or die(mysqli_error());
                            $cat_row = mysqli_fetch_array($cat_query);
                            ?>

                            
                                        <tr>

                                        <td><input type="hidden" name="user_id" value="<?php echo $user_id ?>">
                                            <input class="checkboxes" type="checkbox" name="book_id[]" value="<?php echo $row['book_id']; ?>"></td>
                                        <td style="word-wrap: break-word; width: 17em;"><?php echo $row['book_title']; ?></td>
                                        <td style="word-wrap: break-word; width: 15em;"><?php echo $row['author']; ?></td>
                                        <td><?php echo $cat_row['classname']; ?></td>
                                        <td><?php echo $row['status']; ?></td>
                                        <td><?php echo $row['book_copies']; ?></td>

                                        </tr>
                                    <?php } 


                            $allowable_days_query= mysqli_query($con,"SELECT * from allowed_days order by allowed_days_id DESC ") or die (mysqli_error());
                            $allowable_days_row = mysqli_fetch_assoc($allowable_days_query);

                            $cur_date = date("Y-m-d H:i:s");
                            $due_date = strtotime($cur_date);
                            $due_date = strtotime("+".$allowable_days_row['no_of_days']." day", $due_date);
                            $due_date = date('Y-m-d H:i:s', $due_date);
                            ///$checkout = date('m/d/Y', strtotime("+1 day", strtotime($due_date)));
                                    ?>
                                    </tbody>

                            <input type="hidden" name="due_date" class="new_text" id="sd" value="<?php echo $due_date ?>" size="16" maxlength="10"  />
                            <?php 
                                if (isset($_POST['borrow'])){
                                    $user_id =$_POST['user_id'];
                                    $book_id =$_POST['book_id'];
                                    $date_borrowed =$_POST['borrow_date'];
                                    $due_date =$_POST['due_date'];
                                    for ($i=0; $i<sizeof($book_id); $i++){
                                    $trapBookCount= mysqli_query($con,"SELECT count(*) as books_allowed from borrow_book where not borrowed_status = 'returned' and user_id = '$user_id'") or die (mysqli_error());
                                    
                                    $countBorrowed = mysqli_fetch_assoc($trapBookCount);
                                    
                                    $bookCountQuery= mysqli_query($con,"SELECT count(*) as book_count from borrow_book where not borrowed_status = 'returned' and user_id = '$user_id' and book_id = $book_id[$i]") or die (mysqli_error());
                                    
                                    $bookCount = mysqli_fetch_assoc($bookCountQuery);
                                    
                                    $allowed_book_query= mysqli_query($con,"SELECT * from allowed_book order by allowed_book_id DESC ") or die (mysqli_error());
                                    $allowed = mysqli_fetch_assoc($allowed_book_query);

                                    if ($countBorrowed['books_allowed'] == $allowed['qntty_books']){
                                        echo "<script>alert(' ".$allowed['qntty_books']." ".'Books Allowed per User!'." '); window.location='borrow_book.php?user_id=".$user_id."'</script>";
                                    }elseif ($bookCount['book_count'] == 1){
                                        echo "<script>alert('Book Already Borrowed!'); window.location='borrow_book.php?user_id=".$user_id."'</script>";
                                    }
                                    else{
                                        
                                    $update_copies = mysqli_query($con,"SELECT * from book where book_id = '$book_id[$i]' ") or die (mysqli_error());
                                    $copies_row= mysqli_fetch_assoc($update_copies);
                                    
                                    $book_copies = $copies_row['book_copies'];
                                    $new_book_copies = $book_copies - 1;
                                    
                                    if ($new_book_copies < 0){
                                        echo "<script>alert('Book out of Copy!'); window.location='borrow_book.php?user_id=".$user_id."'</script>";
                                    }elseif ($copies_row['status'] == 'Damaged'){
                                        echo "<script>alert('Book Cannot Borrow At This Moment!'); window.location='borrow_book.php?user_id=".$user_id."'</script>";
                                    }elseif ($copies_row['status'] == 'Lost'){
                                        echo "<script>alert('Book Cannot Borrow At This Moment!'); window.location='borrow_book.php?user_id=".$user_id."'</script>";
                                    }else{
                                        
                                    if ($new_book_copies == '0') {
                                        $remark = 'Not Available';
                                    } else {
                                        $remark = 'Available';
                                    }
                                    
                                    mysqli_query($con,"UPDATE book SET book_copies = '$new_book_copies' where book_id = '$book_id[$i]' ") or die (mysqli_error());
                                    mysqli_query($con,"UPDATE book SET remarks = '$remark' where book_id = '$book_id[$i]' ") or die (mysqli_error());
                                    
                                    mysqli_query($con,"INSERT INTO borrow_book(user_id,book_id,date_borrowed,due_date,borrowed_status)
                                    VALUES('$user_id','$book_id[$i]','$date_borrowed','$due_date','pending')") or die (mysqli_error());  
                                    echo "<script>alert('Request Sent!!'); window.location='borrow_book.php?user_id=$user_id'</script>";
                                    }
                                    }
                                
                                }
                            ?>
                                    <script>
                                        window.location="borrow_book.php?user_id=<?php echo $user_id ?>";
                                    </script>
                            <?php   
                                }
                            ?>
                                </form>
                                </table>
                            </div>
                        </div>                      
                    </div>

    </div>
    <script>
        var limit = <?php $allowed_book_query= mysqli_query($con,"SELECT * from allowed_book order by allowed_book_id DESC ") or die (mysqli_error());
                    $allowed = mysqli_fetch_assoc($allowed_book_query);
                    echo $allowed['qntty_books'];
                    ?>;
$('input.checkboxes').on('change', function(evt) {
   if($("input[name='book_id[]']:checked").length > limit) {
       this.checked = false;
   }
});
</script>