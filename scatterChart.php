<!DOCTYPE html>
<html>
  <head>
    <meta charset='utf-8'>
    <title>Scatter Chart</title>
    <script type='text/javascript' src='https://www.gstatic.com/charts/loader.js'></script>
  </head>
  <body>
    <div id='scatter_chart_div'>
    </div>
    <script type="text/javascript">
    google.charts.load("current", {"packages":["corechart"]});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
         ["date", "no2"],
      <?php
        $reader = new XMLReader();
        $reader->open('xml2/brislington_no2.xml');
        $arr = [];
        while($reader->read()){
          if($reader->name == 'reading'){
            if($reader->getAttribute('time') == "22:00:00"){
              $dateArr = explode('/', $reader->getAttribute('date'));
              $date = 'new Date("'.$dateArr[1].'/'.$dateArr[0].'/'.$dateArr[2].' 22:00:00")';
              $no2 =  $reader->getAttribute('val');
              array_push($arr, '['.$date.','.$no2.']');
            }
          }
        }
        $reader->close();
        $out = implode(',', $arr);
        echo $out;
      ?>
      ]);
      var options = {
        title: "Brislington No2 Data at 8am over the last year",
        hAxis: {title: "date"},
        vAxis: {title: "no2"}
      }
      var chart = new google.visualization.ScatterChart(document.getElementById("scatter_chart_div"));
      chart.draw(data, options);
    }
    </script>
  </body>
</html>
