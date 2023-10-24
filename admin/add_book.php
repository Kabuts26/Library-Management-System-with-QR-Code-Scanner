<?php include ('include/header.php'); 

            include ('database/dbcon.php');
    function generateRandomString($length = 25) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
//usage 
$barcode = generateRandomString(8);
?>

<div class="row justify-content-center">
<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
    <div class="contatin-fluid">

        <div class="row justify-content-center">

            <div class="col-xl-5 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                            <div class="col-lg-0">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Add Book</h1>
                                    </div>
                                    <form class="user" action="" method="post">

                                        <div class="form-group">
                                            <input type="text" name="barcode" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter Book Title" value="<?php echo $barcode; ?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="book_title" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter Book Title" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="author" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter Author" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="number" name="book_copies" class="form-control form-control-user" step="1" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Book Copies" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="number" name="isbn" class="form-control form-control-user" step="1" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="ISBN" required>
                                        </div>
                                        <div class="form-group">
                                            <select name="category_id" class="form-select form-control" tabindex="-1" required>
                                            <option value="none" selected disabled hidden>Select Category</option>
                                        <?php
                                        $result= mysqli_query($con,"select * from category") or die (mysqli_error());
                                        while ($row= mysqli_fetch_array ($result) ){
                                        $id=$row['category_id'];
                                        ?>
                                            <option value="<?php echo $row['category_id']; ?>"><?php echo $row['classname']; ?></option>
                                        <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <select name="status" class="select2_single form-control" tabindex="-1" required>
                                                <option value="none" selected disabled hidden>Select Status</option>
                                              <option value="New">New</option>
                                              <option value="Old">Old</option>
                                              <option value="Damaged">Damaged</option>
                                            </select>
                                        </div>
                                        <button type="submit" name="submit" class="btn btn-primary btn-user btn-block">
                                            Add
                                        </button>
                                        <a href="book.php" class="btn btn-warning btn-user btn-block">
                                            Cancel
                                        </a>
                                    </form>
                                </div>
                            </div>
                    </div>
                </div>
    </div>
    </div>
</div>
</div>

</body>

</html>

<?php 


    include('phpqrcode/qrlib.php');
    if(isset($_POST['submit'])){

        $book_title=$_POST['book_title'];
        $category_id=$_POST['category_id'];
        $author=$_POST['author'];
        $book_copies=$_POST['book_copies'];
        $isbn=$_POST['isbn'];
        $status=$_POST['status'];
        $barcode = $_POST['barcode'];

        if($status == 'Damaged'){
            $remark = 'Not Available';
        } else {
            $remark = 'Available';
        }

        // how to save PNG codes to server
    
    $tempDir = "bookqrcode/";

    $codeContents = $barcode;
    
    // we need to generate filename somehow, 
    // with md5 or with database ID used to obtains $codeContents...
    $fileName = $book_title.'.png';
    
    $pngAbsoluteFilePath = $tempDir.$fileName;
    $urlRelativeFilePath = $tempDir.$fileName;
    
    // generating
    if (!file_exists($pngAbsoluteFilePath)) {
        QRcode::png($codeContents, $pngAbsoluteFilePath);
        echo 'File generated!';
        echo '<hr />';
    } else {
        echo 'File already generated! We can use this cached file to speed up site on common codes!';
        echo '<hr />';
    }

        {
        mysqli_query($con,"insert into book (book_title,category_id,author,book_copies,isbn,status,book_barcode,date_added,remarks,book_qrcode)
        values('$book_title','$category_id','$author','$book_copies','$isbn','$status','$barcode',NOW(),'$remark','$fileName')")or die(mysqli_error());
        
        echo "<script>alert('Successfully Added the Book!'); window.location='book.php?code=".$barcode."'</script>";
        }

    

}

?>