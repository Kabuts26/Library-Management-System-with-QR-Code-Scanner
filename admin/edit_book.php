<?php include ('include/header.php'); 
    include ('database/dbcon.php');
$ID = $_GET['book_id'];

$query1=mysqli_query($con,"select * from book 
    LEFT JOIN category ON book.category_id = category.category_id
    where book_id='$ID'")or die(mysqli_error());
$row=mysqli_fetch_assoc($query1);

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
                                        <h1 class="h4 text-gray-900 mb-4">Edit Book</h1>
                                    </div>
                                    <form class="user" method="post"><div class="form-group">
                                            <input type="text" name="book_title" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp" value="<?php echo $row['book_barcode']; ?>"
                                                placeholder="Barcode" readonly>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="book_title" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp" value="<?php echo $row['book_title']; ?>"
                                                placeholder="Enter Book Title">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="author" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp" value="<?php echo $row['author']; ?>"
                                                placeholder="Enter Author">
                                        </div>
                                        <div class="form-group">
                                            <input type="number" name="copies" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp" value="<?php echo $row['book_copies']; ?>" 
                                                placeholder="Book Copies">
                                        </div>
                                        <div class="form-group">
                                            <select name="category_id" class="form-select form-control" aria-label="Default select example">

                                            <option value="<?php echo $row['category_id']; ?>"><?php echo $row['classname']; ?></option>
                                        <?php
                                        $result= mysqli_query($con,"select * from category") or die (mysqli_error());
                                        while ($cat_row= mysqli_fetch_array ($result) ){
                                        $id=$cat_row['category_id'];
                                        ?>
                                            <option value="<?php echo $row['category_id']; ?>"><?php echo $row['classname']; ?></option>
                                        <?php } ?>

                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <select name="status" class="form-select form-control" aria-label="Default select example">
                                            <option value="<?php echo $row['status']; ?>">
                                                <?php echo $row['status']; ?> </option>
                                              <option value="New">New</option>
                                              <option value="Old">Old</option>
                                              <option value="Damage">Damage</option>
                                            </select>
                                        </div>
                                        <button type="submit" name="submit" class="btn btn-primary btn-user btn-block">
                                            Update
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

<?php 
$id = $_GET['book_id'];
if (isset($_POST['submit'])){

    $book_title=$_POST['book_title'];
    $category_id=$_POST['category_id'];
    $author=$_POST['author'];
    $book_copies=$_POST['copies'];
    $status=$_POST['status'];

    if ($status == 'Damaged') {
        $remark = 'Not Available';
    } else {
        $remark = 'Available';
    }

    mysqli_query($con," UPDATE book SET book_title='$book_title', category_id='$category_id', author='$author', book_copies='$book_copies', status='$status' WHERE book_id = '$id' ")or die(mysqli_error());
echo "<script>alert('Successfully Updated Book Info!'); window.location='book.php'</script>";
}
?>

</body>

</html>