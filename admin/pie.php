<?php 
include('database/dbcon.php');

$pie = mysqli_query($con, "SELECT classname as classname, 
    ( SELECT count(book_copies) FROM book WHERE book.category_id = category.category_id) as total
     FROM book LEFT JOIN category on book.category_id = category.category_id WHERE book.category_id = category.category_id");


?>

    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],

          <?php
                while($pie_row = mysqli_fetch_array($pie)){
                    echo "['".$pie_row['classname']."',".$pie_row['total']."],";
                }
          ?>

        ]);

        var options = {
          title: ''
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>

<div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Books per Category</h6>
                                </div>
                                <!-- Card Body -->
                                    <div class="chart-pie pt-4" id="piechart">
                                    </div>
                            </div>
                        </div>