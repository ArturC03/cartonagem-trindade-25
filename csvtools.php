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

                // Consulta SQL para selecionar os dados dos sensores escolhidos
                // Calcula a data de agora
                $min_datetime = new DateTime($_POST['horaMinima']);
                $max_datetime = new DateTime($_POST['horaMaxima']);

                $result = my_query("
                SELECT id_sensor, date, hour,temperature, humidity, pressure, altitude, eCO2, eTVOC 
                FROM sensors
                WHERE id_sensor IN ('" . implode('\',\'', $sensoresSelecionados) . "')
                AND sensors.date BETWEEN '" . $min_datetime->format('Y-m-d') . "' AND '" . $max_datetime->format('Y-m-d') . "';"
                );                

                if (count($result) > 0) {
                    // Nome do arquivo CSV
                    $filename = "download/dados_sensores.csv";
                    
                    // Cria um arquivo CSV
                    $csvFile = fopen($filename, 'w');
                    
                    $header = ["ID do Sensor", "Hora","Temperatura (°C)", "Humidade (%)", "Pressao (hPa)", "Altitude (m)", "eCO2", "eTVOC"];
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
                    echo $min_datetime->format('Y-m-d H:i:s');
                    echo $max_datetime->format('Y-m-d H:i:s');
                    print_r($sensoresSelecionados);
                }
                exit();
            } else {
                echo "Nenhum dado encontrado para os grupos selecionados.";
                echo $min_datetime->format('Y-m-d H:i:s');
                echo $max_datetime->format('Y-m-d H:i:s');
                print_r($sensoresSelecionados);
            }
            exit();
        } else if (isset($_POST['botaoJSON'])) {
            header("Location:503.html");
        }
    } else {
?>
<div class="container">   
    <div class="sensor-container">
        <h2>Grupos</h2>
        <section class="table_body">
            <?php
            $result = my_query("SELECT grupos.id_grupo, grupos.grupo, GROUP_CONCAT(DISTINCT id_sensor) AS id_sensors FROM location, grupos WHERE location.grupo = grupos.id_grupo GROUP BY grupo ORDER BY id_grupo;");
            
            $grupos = array();
            $gruposSensores = array();
            
            foreach ($result as $row) {
                $id = $row["id_grupo"];
                $grupo = $row["grupo"];
                $sensors = $row["id_sensors"];
                
                if (!isset($gruposSensores[$grupo])) {
                    $gruposSensores[$grupo] = array();
                }

                $grupos[$id] = $grupo;
                
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
                foreach ($grupos as $k => $v) {
                    echo '<option value="' . $k . '">Grupo ' . $v . '</option>';
                }
                ?>
            </select>
            <div class="sensor-update">
            </div>
            <h2>Período</h2>
            <input type="date" name="horaMinima" id="horaMinima" step="1" required>
            <input type="date" name="horaMaxima" id="horaMaxima" step="1" required>
            
            <div class="button-container">
                <button type="submit" class="btn-success" id="botaoCSV" name="botaoCSV">Gerar CSV</button>
                <button type="submit" class="btn-success" id="botaoJSON" name="botaoJSON">Gerar JSON</button>
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