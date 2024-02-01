<?php 
include('config.inc.php');

$periodo_geracao = $argv[1];

$result = my_query("SELECT * FROM hora WHERE periodo_geracao = " . $periodo_geracao . ";");

if ($periodo_geracao == "MINUTE") {
    $min_datetime = date('Y-m-d H:i:s', strtotime('-1 minute'));
    $max_datetime = date('Y-m-d H:i:s');
} else if ($periodo_geracao == "HOURLY") {
    $min_datetime = date('Y-m-d H:i:s', strtotime('-1 hour'));
    $max_datetime = date('Y-m-d H:i:s');
} else if ($periodo_geracao == "DAILY") {
    $min_datetime = date('Y-m-d H:i:s', strtotime('-1 day'));
    $max_datetime = date('Y-m-d H:i:s');
} else if ($periodo_geracao == "WEEKLY") {
    $min_datetime = date('Y-m-d H:i:s', strtotime('-1 week'));
    $max_datetime = date('Y-m-d H:i:s');
} else if ($periodo_geracao == "MONTHLY") {
    $min_datetime = date('Y-m-d H:i:s', strtotime('-1 month'));
    $max_datetime = date('Y-m-d H:i:s');
}

foreach ($result as $row) {
    $result2 = my_query(
        "SELECT id_sensor, date, hour, temperature, humidity, pressure, altitude, eCO2, eTVOC 
        FROM sensors
        WHERE id_sensor IN ('" . (mb_strpos($row['sensores'], ',') ? implode('\',\'', $row['sensores']) : $row['sensores']) . "')
        AND sensors.date BETWEEN '" . $min_datetime->format('Y-m-d') . "' AND '" . $max_datetime->format('Y-m-d') . "';"
    );                

    $fileName = __DIR__ . "/download/scheduled/" . $row['id_hora'] . "/" . $row['num_ficheiros'] . ".csv";

    $file = fopen($fileName, 'w');

    fputcsv($file, array('id_sensors', 'Data', 'Hora', 'Temperatura', 'Humidade','Pressão', 'Altitude', 'CO2', 'TVOC'), ';');

    if (count($result2) > 0) {
        foreach ($result2 as $row2) {
            $formattedTemperature = ltrim(sprintf("%.3f", $row2['temperature']), '0');
            $row2['temperature'] = $formattedTemperature;
            $formattedHumidity = ltrim(sprintf("%.3f", $row2['humidity']), '0');
            $row2['humidity'] = $formattedHumidity;
            
            $formattedPressure = ltrim(sprintf("%.3f", $row2['pressure']), '0');
            $row2['pressure'] = $formattedPressure;
            
            $formattedCo2 = ltrim(sprintf("%.3f", $row2['eCO2']), '0');
            $row2['eCO2'] = $formattedCo2;
            
            $formattedTvoc = ltrim(sprintf("%.3f", $row2['eTVOC']), '0');
            $row2['eTVOC'] = $formattedTvoc;
            
            fputcsv($file, $row2, ';');
        }
    }
    fclose($file);
    
    if (my_query("UPDATE hora SET num_ficheiros = " . ($row['num_ficheiros'] + 1) . " WHERE id_hora = " . $row['id_hora'] . ";") == 0) {
        echo "Erro ao atualizar o número de ficheiros, por favor contacte o administrador da BD";
    }
}