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

$grupo = $_POST['grupo']; // Recupere o grupo selecionado

// Consulta SQL para obter a lista de sensores com base no grupo
$sql = "SELECT location.id_sensor, location.location_x, location.location_y, CAST(CONV(RIGHT(sensors.id_sensor, 2), 16, 10) AS SIGNED) AS id_sensor_decimal, sensors.Active
        FROM location
        INNER JOIN sensors ON location.id_sensor = sensors.id_sensor
        WHERE location.grupo = $grupo
        GROUP BY location.id_sensor";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="col-md-2 form-check">'; // Col-md-4 para criar três colunas
        echo '<input type="checkbox" class="form-check-input" name="sensores[]" value="' . $row['id_sensor'] . '">';
        echo '<label class="form-check-label">' . $row['id_sensor'] . '</label>';
        echo '</div>';
        echo '<br>';
    }
} else {
    echo "Nenhum sensor encontrado para este grupo.";
}

$conn->close();
?>
