<?php
  $con = mysqli_connect('localhost', 'root', '', 'transfer');
  date_default_timezone_set('Asia/Seoul');
  $now = date("Y-m-d H:i:s");
?>

<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['transtime', 'temp'],
          <?php
          $query = "SELECT transtime, temp FROM seogu_3data ORDER BY transtime";
          $current = strtotime($now);
          $exec = mysqli_query($con, $query);
          while($row = mysqli_fetch_assoc($exec)){
            $transtime = strtotime(($row['transtime']));
            $diff = $current - $transtime;
            if($row['transtime']>="2017-04-30 00:00:00")
              echo "['".$row['transtime']."',".$row['temp']."],";
          }
          ?>
        ]);

        var options = {
          title: '서구온도',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="curve_chart" style="width: 900px; height: 500px"></div>
  </body>
</html>