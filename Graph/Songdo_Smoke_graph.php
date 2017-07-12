<?php
	$con = mysqli_connect('localhost', 'root', '', 'transfer');

?>

<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
        	['transtime', 'smoke'],
        	<?php
        	$query = "SELECT transtime, smoke FROM Songdo_3data ORDER BY transtime";

        	$exec = mysqli_query($con, $query);
        	while($row = mysqli_fetch_assoc($exec)){
            if($row['transtime']>="2017-04-30 00:00:00")
        		  echo "['".$row['transtime']."',".$row['smoke']."],";
        	}
        	?>
        ]);

        var options = {
          title: '송도 연기',
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