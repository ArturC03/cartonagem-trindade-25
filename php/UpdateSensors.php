<?php
/**
 * Returns the list of sensors.
 */
require 'connect.php';
//$_POST = json_decode(file_get_contents('php://button'),true);  
error_reporting(0);  
$id = '010A';//$_GET['id'];

$sensors = [];
$sql = "SELECT sensor_id, hour, temperature , humidity , pressure , altitude , ativo FROM sensors where id_sensor='$id' LIMIT 8";

$sensorsSensor_id =[] ;   
$sensorsTemperature2=[];
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
    $sensorsTemperature2[] = $row['temperature'];
    $sensorsHour[] = $row['hour'];
    $sensorsDate[] = $row['date'];
    $sensorsHumidity[] = $row['humidity'];
    $sensorsPpressure[] = $row['pressure'];
    $sensorsAltitude[] = $row['altitude'];
    $sensorsAtivo[] = $row['ativo'];

   

   
  }

   json_encode($sensorsTemperature2);
   json_encode($sensorsHumidity);
   json_encode($sensorsPpressure);
}
else
{
  http_response_code(404);
}