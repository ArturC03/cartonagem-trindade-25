<?php 
    include('config.inc.php');

    if ($_GET['submit'] == "CSV") {
        if (isset($_GET['sensores'])) {
            ob_clean();
            // Processar a geração do CSV aqui
            $sensoresSelecionados = $_POST['sensores'];

            if (isset($_GET['horaSelecionada'])) {
                $min_datetime = date_sub(new DateTime($_GET['horaSelecionada']), new DateInterval('P1W'));
                $max_datetime = new DateTime($_GET['horaSelecionada']);
            } else if ($_GET['periodoSelecionado'] == "MINUTE") {
                $min_datetime = date('Y-m-d H:i:s', strtotime('-1 minute'));
                $max_datetime = date('Y-m-d H:i:s');
            } else if ($_GET['periodoSelecionado'] == "HOURLY") {
                $min_datetime = date('Y-m-d H:i:s', strtotime('-1 hour'));
                $max_datetime = date('Y-m-d H:i:s');
            } else if ($_GET['periodoSelecionado'] == "DAILY") {
                $min_datetime = date('Y-m-d H:i:s', strtotime('-1 day'));
                $max_datetime = date('Y-m-d H:i:s');
            } else if ($_GET['periodoSelecionado'] == "WEEKLY") {
                $min_datetime = date('Y-m-d H:i:s', strtotime('-1 week'));
                $max_datetime = date('Y-m-d H:i:s');
            } else if ($_GET['periodoSelecionado'] == "MONTHLY") {
                $min_datetime = date('Y-m-d H:i:s', strtotime('-1 month'));
                $max_datetime = date('Y-m-d H:i:s');
            }

            $result = my_query("
            SELECT id_sensor, date, hour, temperature, humidity, pressure, altitude, eCO2, eTVOC 
            FROM sensors
            WHERE id_sensor IN ('" . implode('\',\'', $sensoresSelecionados) . "')
            AND sensors.date BETWEEN '" . $min_datetime->format('Y-m-d') . "' AND '" . $max_datetime->format('Y-m-d') . "';"
            );                

            if (count($result) > 0) {
                // Nome do arquivo CSV
                $fileName = "download/dados_scheduled.csv";
                
                // Cria um arquivo CSV
                $csvFile = fopen($fileName, 'w');
                
                $file = fopen($fileName, 'w');
                fputcsv($file, array('id_sensors', 'Data', 'Hora', 'Temperatura', 'Humidade','Pressão', 'Altitude', 'CO2','TVOC'),';');
                foreach ($result as $row) {
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
                fclose($file);
                
                // Define os cabeçalhos para download
                header('Content-Type: text/csv');
                header('Content-Disposition: attachment; filename="' . $fileName . '"');
                
                // Lê e envia o arquivo CSV para o cliente
                readfile($fileName);
            }
        }
    }