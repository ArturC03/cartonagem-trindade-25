<?php
include('config.inc.php');

if (isset($_SESSION['username'])) {
    include('header.inc.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['botaoCSV'])){

            if (isset($_POST['sensores'])) {
                ob_clean();
                // Processar a geração do CSV aqui
                $sensoresSelecionados = $_POST['sensores'];
                array_splice($sensoresSelecionados, 0, 1);

                // Consulta SQL para selecionar os dados dos sensores escolhidos
                // Calcula a data de agora
                $min_datetime = $_POST['horaMinima'];
                $max_datetime = $_POST['horaMaxima'];
                
                // Sua consulta SQL
                
                $result = my_query("
                SELECT id_sensor, date, hour,temperature, humidity, pressure, altitude, eCO2, eTVOC 
                FROM sensors
                WHERE id_sensor IN (" . implode(',', $sensoresSelecionados) . ")
                AND (date >= DATE('$min_datetime') AND date <= DATE('$max_datetime') AND hour >= TIME('$min_datetime') AND hour <= TIME('$max_datetime'))
                ");
                
                if (count($result) > 0) {
                    // Nome do arquivo CSV
                    $filename = "dados_sensores.csv";
                    
                    // Cria um arquivo CSV
                    $csvFile = fopen($filename, 'w');
                    
                    $header = ["ID do Sensor", "Hora","Temperatura (°C)", "Umidade (%)", "Pressão (hPa)", "Altitude (m)", "eCO2", "eTVOC"];
                    fputcsv($csvFile, $header);
                    
                    foreach ($result as $row) {
                        // Formate os dados conforme necessário
                        $formattedData = [
                            $row['id_sensor'],
                            $row['hour'],
                            $row['temperature'],
                            $row['humidity'],
                            $row['pressure'],
                            $row['altitude'],
                            $row['eCO2'],
                            $row['eTVOC']
                        ];
                        fputcsv($csvFile, $formattedData);
                    }
                    
                    // Fecha o arquivo CSV
                    fclose($csvFile);
                    
                    // Define os cabeçalhos para download
                    header('Content-Type: text/csv');
                    header('Content-Disposition: attachment; filename="' . $filename . '"');
                    
                    // Lê e envia o arquivo CSV para o cliente
                    readfile($filename);
                } else {
                    echo "Nenhum dado encontrado para os sensores selecionados.";
                    echo $min_datetime;
                    echo $max_datetime;
                    print_r($sensoresSelecionados);
                }
                exit();
            } else {
                echo "Nenhum dado encontrado para os grupos selecionados.";
                echo $min_datetime;
                echo $max_datetime;
                print_r($sensoresSelecionados);
            }
            exit();
        } else if (isset($_POST['botaoJSON'])) {
            //FAZER JSON
        }
    } else {
?>
<div class="container">   
    <div class="sensor-container">
        <h2>Grupos</h2>
        <section class="table_body">
            <?php
            $result = my_query("SELECT grupo+1 AS grupo, GROUP_CONCAT(DISTINCT id_sensor) AS id_sensors FROM location GROUP BY grupo;");
            
            $gruposSensores = array();
            
            foreach ($result as $row) {
                $grupo = $row["grupo"];
                $sensors = $row["id_sensors"];
                
                if (!isset($gruposSensores[$grupo])) {
                    $gruposSensores[$grupo] = array();
                }
                
                $sensor = explode(",", $sensors);
                
                foreach ($sensor as $s) {
                    if (!in_array($s, $gruposSensores[$grupo])) {
                        $gruposSensores[$grupo][] = $s;
                    }
                }
            }
            
            echo '<table>';
            echo '<thead>';
            echo '<tr><th>Grupo</th><th>Sensores</th></tr>';
            echo '</thead>';
            
            echo '<tbody>';
            foreach ($gruposSensores as $grupo => $sensores) {
                echo '<tr>';
                echo '<td>' . $grupo . '</td>';
                echo '<td>' . implode(", ", $sensores) . '</td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
            
            ?>    
        </section>
    </div>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="sensor-container">
            <h2>Selecione o Grupo</h2>
            <select name="grupo">
                <?php
                foreach ($gruposSensores as $grupo => $sensores) {
                    echo '<option value="' . $grupo . '">Grupo ' . $grupo . '</option>';
                }
                ?>
            </select>
            <div class="sensor-update">
                <label class="check-container">
                    <input type="checkbox" name="todos" id="todos" value="Selecionar Tudo">
                    <div class="checkmark"></div>
                    <span>Selecionar todos</span>
                </label>
                <?php
                $result = my_query("
                SELECT location.id_sensor, location.location_x,location.location_y, CAST(CONV(RIGHT(sensors.id_sensor, 2), 16, 10) AS SIGNED) AS id_sensor_decimal,sensors.Active
                FROM location
                INNER JOIN sensors ON 
                location.id_sensor = sensors.id_sensor
                where location.grupo=$grupo GROUP BY location.id_sensor
                ");
                
                if (count($result) > 0) {
                    foreach ($result as $row) {
                        echo '<label class="check-container">';
                        echo '<input type="checkbox" class="checkbox" name="sensores[]" value="' . $row['id_sensor'] . '">';
                        echo '<div class="checkmark"></div>';
                        echo '<span>' . $row['id_sensor'] . '</span>';
                        echo '</label>';
                    }
                } else {
                    echo "Nenhum sensor encontrado.";
                }
                ?>
            </div>
            <h2>Período</h2>
            <input type="datetime-local" name="horaMinima" id="horaMinima" step="1" required>
            <input type="datetime-local" name="horaMaxima" id="horaMaxima" step="1" required>
            
            <div class="button-container">
                <button type="submit" class="btn-success" id="BotaoCSV">Agendar CSV</button>
                <button type="submit" class="btn-success" id="BotaoJSON">Agendar JSON</button>
            </div>
        </div>        
        </form>
    </div>
</div>
<script src="js/csvtools.js"></script>
<?php
    include('footer.inc.php');
    }
}else{
    header('Location: login.php');
}