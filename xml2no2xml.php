<!DOCTYPE html>
<html>
  <head>
    <meta charset='utf-8'>
    <title>Line Chart</title>
    <script type='text/javascript' src='https://www.gstatic.com/charts/loader.js'></script>
  </head>
  <body>
    <form name="dropdown" action="lineChart.php" method="GET">
      <select name="date">
      <?php
      $reader = new XMLReader();
      $reader->open('xml2/brislington_no2.xml');
      $dateArr = [];
        while($reader->read()){
          if($reader->name == 'reading'){
            $date = $reader->getAttribute('date');
            if(!in_array($date, $dateArr)){
              array_push($dateArr, $date);
            }
          }
        }
        for($i=0;$i<count($dateArr);$i++){
          echo '<option name="date">'.$dateArr[$i].'</option>';
        }
      ?>
    </select>
    <button type="submit">Submit</button>
    </form>
    <div id='line_chart_div'>
    </div>
    <script type="text/javascript">
    google.charts.load("current", {"packages":["corechart"]});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
         ["hour", "no2"],
      <?php
        $reader = new XMLReader();
        $reader->open('xml2/brislington_no2.xml');
        $hourArr = [];
        while($reader->read()){
          if($reader->name == 'reading'){
            if($reader->getAttribute('date') == $_GET['date']){
              $dateArr = explode('/', $reader->getAttribute('date'));
              $hour = $reader->getAttribute('time');
              $no2 =  $reader->getAttribute('val');
              array_push($hourArr, '[new Date("'.$dateArr[1].'/'.$dateArr[0].'/'.$dateArr[2].' '.$hour.'"),'.$no2.']');
            }
       