<?php 
  include('database/dbcon.php');

  $bar1 = mysqli_fetch_array( mysqli_query($con, "SELECT COUNT(*) AS avail FROM book WHERE remarks = 'Available'"));
  $bar2 = mysqli_fetch_array( mysqli_query($con, "SELECT COUNT(*) AS not_avail FROM book WHERE remarks = 'Not Available'"));

?>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['','Available', 'Not Available'],

          ['<?php echo $bar1['avail']; ?>', <?php echo $bar1['avail']; ?>,<?php echo $bar2['not_avail']; ?>],
        ]);

        var options = {
          chart: {
            title: '',
            subtitle: '',
          },
          bars: 'ertical' // Required for Material Bar Charts.
        };

        var chart = new google.charts.Bar(document.getElementById('barchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>

                        <!-- Bar Chart -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary"> Total of Available and Not Available Book</h6>
                                </div>
                                <div class="card-body">
                                  <div class="chart-bar" id="barchart_material">
                                  </div>
                                </div>
                            </div>
                          </div>
