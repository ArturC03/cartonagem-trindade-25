<?php 
include('config.inc.php');

ob_clean();
$id = $argv[1];

$result = my_query("SELECT * FROM hora WHERE id_hora = " . $id . ";");

if ($result[0]['data_geracao'] != '') {
    $min_datetime = date_sub(new DateTime($result[0]['data_geracao']), new DateInterval('P1W'));
    $max_datetime = new DateTime($result[0]['data_geracao']);
} else if ($result[0]['periodo_geracao'] == "MINUTE") {
    $min_datetime = date('Y-m-d H:i:s', strtotime('-1 minute'));
    $max_datetime = date('Y-m-d H:i:s');
} else if ($result[0]['periodo_geracao'] == "HOURLY") {
    $min_datetime = date('Y-m-d H:i:s', strtotime('-1 hour'));
    $max_datetime = date('Y-m-d H:i:s');
} else if ($result[0]['periodo_geracao'] == "DAILY") {
    $min_datetime = date('Y-m-d H:i:s', strtotime('-1 day'));
    $max_datetime = date('Y-m-d H:i:s');
} else if ($result[0]['periodo_geracao'] == "WEEKLY") {
    $min_datetime = date('Y-m-d H:i:s', strtotime('-1 week'));
    $max_datetime = date('Y-m-d H:i:s');
} else if ($result[0]['periodo_geracao'] == "MONTHLY") {
    $min_datetime = date('Y-m-d H:i:s', strtotime('-1 month'));
    $max_datetime = date('Y-m-d H:i:s');
}

$result2 = my_query("
SELECT id_sensor, date, hour, temperature, humidity, pressure, altitude, eCO2, eTVOC 
FROM sensors
WHERE id_sensor IN ('" . (mb_strpos($result[0]['sensores'], ',') ? implode('\',\'', $result[0]['sensores']) : $result[0]['sensores']) . "')
AND sensors.date BETWEEN '" . $min_datetime->format('Y-m-d') . "' AND '" . $max_datetime->format('Y-m-d') . "';"
);                


$fileName = __DIR__ . "/download/scheduled/" . $id . "/" . $result[0]['num_ficheiros'] . ".csv";

$file = fopen($fileName, 'w');

fputcsv($file, array('id_sensors', 'Data', 'Hora', 'Temperatura', 'Humidade','Pressão', 'Altitude', 'CO2','TVOC'),';');

if (count($result2) > 0) {
    foreach ($result2 as $row) {
        $formattedTemperature = ltrim(sprintf("%.3f", $row['temperature']), '0');
        $row['temperature'] = $formattedTemperature;
        $formattedHumidity = ltrim(sprintf("%.3f", $row['humidity']), '0');
        $row['humidity'] = $formattedHumidity;
        
        $formattedPressure = ltrim(sprintf("%.3f", $row['pressure']), '0');
        $row['pressure'] = $formattedPressure;

        $formattedCo2 = ltrim(sprintf("%.3f", $row['eCO2']), '0');
        $row['eCO2'] = $formattedCo2;

        $formattedTvoc = ltrim(sprintf("%.3f", $row['eTVOC']), '0');
        $row['eTVOC'] = $formattedTvoc;
        
        fputcsv($file, $row,';');
    }
}
fclose($file);

if (my_query("UPDATE hora SET num_ficheiros = " . ($result[0]['num_ficheiros'] + 1) . " WHERE id_hora = " . $id . ";") == 0) {
    echo "Erro ao atualizar o número de ficheiros, por favor contacte o administrador da BD";
}