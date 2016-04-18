<?php


$data = $_POST;

$artikelnummer = $data['artikelnummer'];
//$cName =  $data['cName'];
$cName = str_replace(' ', '', $data['cName']);
$data['artikelnummer'] = false;
$data['cName'] = false;



output($data, $artikelnummer, $cName);
function output($data, $artikelnummer, $cName) {

  // output headers so that the file is downloaded rather than displayed
  header('Content-Type: text/csv; charset=utf-8');
  header('Content-Disposition: attachment; filename='.$artikelnummer.'-' . $cName . '.csv');

  // create a file pointer connected to the output stream
  $output = fopen('php://output', 'w');
	
  // output the column headings

  while (list($key, $value) = each($data)) {
    if($value) {
      if($key == 'Funktionsattributname') {
        $rows = array($key,$value,'Artikelnummer');
      } else {
        $rows = array($key,$value,$artikelnummer);
      }
      fputcsv($output, $rows);
    }
  }
  fclose($output);
}

