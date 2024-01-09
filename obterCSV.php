<?php
$result2 = my_query("SELECT id_sensor,hour,date,temperature,humidity,pressure,eCO2,eTVOC from sensors where id_sensor in $sensores order by date ASC");
$fileName = 'download/dados.csv';

$file = fopen($fileName, 'w');
fputcsv($file, array('id_sensors', 'Hora', 'Data', 'Temperatura', 'Humidade','Pressão','CO2','TVOC'),';');
foreach ($result2 as $row) {
    $formattedTemperature = ltrim(sprintf("%.3f", $row[3]), '0');
    $row[3] = $formattedTemperature;
    $formattedHumidity = ltrim(sprintf("%.3f", $row[4]), '0');
    $row[4] = $formattedHumidity;
    
    $formattedPressure = ltrim(sprintf("%.3f", $row[5]), '0');
    $row[5] = $formattedPressure;
    
    fputcsv($file, $row,';');
}
@header('Content-Type: text/csv');
@header('Content-Disposition: attachment; filename="' . $fileName . '"');
fclose($file);

header('Location: download/dados.csv');