<?php
include('include/config.inc.php');

$result = my_query("SELECT 
    location.id_sensor,
    location.location_x,
    location.location_y,
    location.size_x,
    location.size_y,
    CAST(sensors.temperature AS SIGNED) AS temperatura_int,
    location.status,
    CAST(CONV(RIGHT(sensors.id_sensor, 2), 16, 10) AS SIGNED) AS id_sensor_decimal
FROM 
    location
INNER JOIN 
    sensors 
ON 
    location.id_sensor = sensors.id_sensor
WHERE 
    CAST(sensors.temperature AS SIGNED) > 1 
    AND location.status = 1
    AND
    sensors.sensor_id IN (
        SELECT 
            MAX(sensor_id) AS max_sensor_id
        FROM 
            sensors
        GROUP BY 
            id_sensor
    )
;
");

$data = array();

foreach ($result as $row) {
  $data[] = array(
    'x' => $row['location_x'],
    'y' => $row['location_y'],
    'size_x' => $row['size_x'],
    'size_y' => $row['size_y'],
    'value' => $row['temperatura_int'],
  );
}

echo json_encode(array(
  'min' => 0,
  'max' => 35,
  'data' => $data
));