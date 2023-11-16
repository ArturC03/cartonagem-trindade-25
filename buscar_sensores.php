<?php
// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "plantdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$grupo = $_GET['grupo'];

$sql = "SELECT location.id_sensor, location.location_x, location.location_y, CAST(CONV(RIGHT(sensors.id_sensor, 2), 16, 10) AS SIGNED) AS id_sensor_decimal, sensors.Active
        FROM location
        INNER JOIN sensors
        ON location.id_sensor = sensors.id_sensor
        WHERE location.grupo = $grupo
        GROUP BY location.id_sensor";

$result = $conn->query($sql);

$sensores = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $sensores[] = array(
            'id_sensor' => $row['id_sensor'],
        );
    }
}

$conn->close();

// Retorna os sensores como JSON
header('Content-Type: application/json');
echo json_encode($sensores);
?>
