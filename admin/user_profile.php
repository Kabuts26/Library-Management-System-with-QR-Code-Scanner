<?php  include('include/header.php'); 
        include('database/dbcon.php');

$id = $_GET['user_id'];

$user_query  = mysqli_query($con,"select * from user where user_id = '$id'")or die(mysqli_error());
$row =mysqli_fetch_array($user_query);
?>
<div class="row justify-content-center">
<div id="content-wrapper" class="d-flex flex-column">
	<div id="content">
	<div class="contatin-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 ml-5 text-gray-800">Personal Information</h1>
        </div>
     		<div class="card">
                <div class="card-body"></li>
                    <ul>
                        <li>Member QR Code: <img src="../userqrcode/<?php echo $row['user_qrcode'] ?>" class="rounded d-block" alt="user_qrcode">
     					<li>Name: <?php echo $row['firstname']." ".$row['middlename']." ".$row['lastname']; ?></li>
     					<li>Address: <?php echo $row['address']?></li>
     					<li>Contact Number: <?php echo $row['contact']?></li>
     					<li>Email Address: <?php echo $row['email']?></li>
     				</ul>
     			</div>
     		</div>
	</div>
</div>
</div>

<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
    <div class="contatin-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mt-4 mb-4">
            <h1 class="h3 mb-0 ml-5 text-gray-800">Borrowed Books</h1>
        </div><!-- DataTable Start -->
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
                                            <th>Date Returned</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                            <?php
                                $borrow_query = mysqli_query($con,"SELECT * FROM borrow_book
                                    LEFT JOIN book ON borrow_book.book_id = book.book_id 
                                    LEFT JOIN user ON borrow_book.user_id = user.user_id 
                                    WHERE borrowed_status = 'borrowed' and user.user_id = '$id'
                                    ORDER BY borrow_book.borrow_book_id DESC") or die(mysqli_error());
                                $borrow_count = mysqli_num_rows($borrow_query);
                                while($borrow_row = mysqli_fetch_array($borrow_query)){
                                    $id = $borrow_row ['borrow_book_id'];
                                    $book_id = $borrow_row ['book_id'];
                                    $user_id = $borrow_row ['user_id'];
                            ?>
                                            <tr>
                                            <td><?php echo $borrow_row['book_title']; ?></td>
                                            <td><?php echo $borrow_row['author']; ?></td>
                                            <td><?php echo date("M d, Y h:m:s a",strtotime($borrow_row['date_borrowed'])); ?></td>
                                            <td><?php echo date("M d, Y h:m:s a",strtotime($borrow_row['due_date'])); ?></td>
                                        <?php
                                            if ($borrow_row['borrowed_status'] != 'returned') {
                                                echo "<td class='alert alert-success'>".$borrow_row['borrowed_status']."</td>";
                                            } else {
                                                echo "<td  class='alert alert-danger'>".$borrow_row['borrowed_status']."</td>";
                                            }
                                        ?>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>                      
                    </div>
                </div>
            </div>
    </div>
</div>
</div>
</div>
