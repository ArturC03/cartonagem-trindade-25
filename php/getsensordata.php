<?php
// Conecta ao banco de dados
$conn = new mysqli('localhost', 'root', '', 'plantdb');

// Checa se a conexão foi bem sucedida
if ($conn->connect_error) {
  die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}


// Consulta os valores dos sensores
$result = $conn->query("SELECT 
    location.id_sensor,
    location.location_x,
    location.location_y,
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






// Cria um array para armazenar os dados dos sensores
$data = array();

// Adiciona cada linha do resultado da consulta ao array
while ($row = $result->fetch_assoc()) {
  $data[] = array(
    'x' => $row['location_x'],
    'y' => $row['location_y'],
    'value' => $row['temperatura_int'],
  );
}

// Retorna os dados como JSON
echo json_encode(array(
  'min' => 0,
  'max' => 35,
  'data' => $data
));
?>