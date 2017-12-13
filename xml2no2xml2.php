<?php
  //Get all files and put in $files array
  $files = glob('xml/*xml');

  //Check if there are multiple files
  if(is_array($files)){
    //Loop through each file
    foreach($files as $filename){
      $reader = new XMLReader();
      $reader->open($filename);
      //If reader cannot open the file end program
      if(!$reader->open($filename)){
        die('Failed to open'.$filename);
      }
      $date = [];
      $time = [];
      $no2 = [];
      //Loop through file
      while($reader->read()){
        // Get Desciption, Lat & Long values

        if($reader->name == 'desc'){
          $name = $reader->getAttribute('val');
        }
        if($reader->name == 'lat'){
          $lat = $reader->getAttribute('val');
        }
        if($reader->name == 'long'){
          $long = $reader->getAttribute('val');
        }
        if($reader->name == 'date'){
          array_push($date, $reader->getAttribute('val'));
        }
        if($reader->name == 'time'){
          array_push($time, $reader->getAttribute('val'));
        }
        if($reader->name == 'no2'){
          array_push($no2, $reader->getAttribute('val'));
        }
      }

      $reader->close();
      //Start the xml output string
      $new_filename = str_replace(' ', '_', $name);
      $new_filename = strtolower($new_filename.'_no2.xml');

      $writer = new XMLWriter();
      $writer->openURI($new_filename);
      $writer->startDocument('1.0', 'UTF-8');
      $writer->setIndent(true);
      $writer->startElement('data');
        $writer->writeAttribute('type', 'nitrogen dioxide');
        $writer->startElement('location');
          $writer->writeAttribute('id', $name);
          $writer->writeAttribute('lat', $lat);
          $writer->writeAttribute('long', $long);
          // A for loop looks through the date array and then produces each reading, this for loop only looks at the date array because each array in this case will be the same length.
          for($i=0;$i<count($date);$i++){
            $writer->startElement('reading');
              $writer->writeAttribute('date', $date[$i]);
              $writer->writeAttribute('time', $time[$i]);
              $writer->writeAttribute('val', $no2[$i]);
            $writer->endElement();
          }
          $writer->endElement();
          $writer->endElement();
          $writer->endDocument();
          $writer->flush();
    }
  }
?>
