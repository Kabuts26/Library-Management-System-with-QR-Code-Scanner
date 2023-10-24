 <?php 
 include ('database/dbcon.php');

 $query = mysqli_query($con, "SELECT COUNT(*) as total, MONTHNAME(date_returned) as month FROM return_book GROUP BY MONTHNAME(date_returned) ORDER BY MONTHNAME(date_returned)");

 ?>

 <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Month', 'Total',],

          <?php 
            while($row = mysqli_fetch_array($query)){
                $month = $row['month'];
                $total = $row['total'];
            
          ?>
            ['<?php echo $month; ?>',<?php echo $total; ?>],
      <?php } ?>
        ]);

        var options = {
          title: '',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }
    </script>                       





                        <!-- Line Chart -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary"> Total Transaction</h6>
                                </div>
                                <div class="card-body ">
                                  <div class="chart-bar" id="curve_chart">
                                  </div>
                                </div>
                            </div>
                          </div>