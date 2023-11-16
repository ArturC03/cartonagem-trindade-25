<?php
/**
 * Returns the list of sensors.
 */
require 'connect.php';
error_reporting(0); 
$sensors = [];
$sql = "SELECT sensor_id,temperature ,
date, hour , humidity , pressure , 
altitude , ativo FROM sensors where id_sensor='0101'  LIMIT 8";

$sensorsSensor_id =[] ;   
$sensorsTemperature=[];
$sensorsHour=[] ;
$sensorsDate=[] ;
$sensorsHumidity=[];
$sensorsPpressure=[] ;
$sensorsAltitude=[];
$sensorsAtivo=[];

if($result = mysqli_query($con,$sql))
{
   
  while($row = mysqli_fetch_array($result))
  {
    $sensorsSensor_id[]    = $row['sensor_id'];
    $sensorsTemperature[] = $row['temperature'];
    $sensorsHour[] = $row['hour'];
    $sensorsDate[] = $row['date'];
    $sensorsHumidity[] = $row['humidity'];
    $sensorsPpressure[] = $row['pressure'];
    $sensorsAltitude[] = $row['altitude'];
    $sensorsAtivo[] = $row['ativo'];

   

   
  }

   json_encode($sensorsTemperature);
   json_encode($sensorsHumidity);
   json_encode($sensorsPpressure);
}
else
{
  http_response_code(404);
}
