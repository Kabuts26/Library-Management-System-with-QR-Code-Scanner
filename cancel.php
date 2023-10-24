<?php 

include('database/dbcon.php');

$borrow_book_id=$_GET['borrow_book_id'];

$quer = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM borrow_book WHERE borrow_book_id = '$borrow_book_id'"));
$book_id = $quer['book_id'];

$update_copies = mysqli_query($con,"SELECT * from book where book_id = '$book_id' ") or die (mysqli_error());
                $copies_row= mysqli_fetch_assoc($update_copies);
                
                $book_copies = $copies_row['book_copies'];
                $new_book_copies = $book_copies + 1;
    mysqli_query($con,"UPDATE book SET book_copies = '$new_book_copies' where book_id = '$book_id'") or die (mysqli_error());

mysqli_query($con,"DELETE FROM borrow_book WHERE borrow_book_id = '$borrow_book_id' ")or die(mysqli_error());
header("location:home.php?user_id='.$id_session.'");
?>