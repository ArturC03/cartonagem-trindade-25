<?php
if (isset($_SESSION['username'])) {
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['sensores'])) {
        ob_clean();
        // Processar a geração do CSV aqui
        $sensoresSelecionados = $_POST['sensores'];
        
        // Conexão com o banco de dados 
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "plantdb";
        
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Falha na conexão: " . $conn->connect_error);
        }
        
        // Consulta SQL para selecionar os dados dos sensores escolhidos
        // Calcula a data de agora
        $current_date = date('Y-m-d');
        $current_time = date('H:i:s');
        
        // Calcula a data e hora de ontem à mesma hora
        $yesterday_datetime = date('Y-m-d', strtotime('-1 day')) . ' ' . $current_time;
        
        // Sua consulta SQL
        $sql = "SELECT id_sensor, hour,temperature, humidity, pressure, altitude, eCO2, eTVOC 
        FROM sensors
        WHERE id_sensor IN (" . implode(',', $sensoresSelecionados) . ")
        AND ((date = '$current_date' AND hour <= '$current_time') OR (date = '$current_date' AND hour >= '$yesterday_datetime'))";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            // Nome do arquivo CSV
            $filename = "dados_sensores.csv";
            
            // Cria um arquivo CSV
            $csvFile = fopen($filename, 'w');
            
            $header = ["ID do Sensor", "Hora","Temperatura (°C)", "Umidade (%)", "Pressão (hPa)", "Altitude (m)", "eCO2", "eTVOC"];
            fputcsv($csvFile, $header);
            
        while ($row = $result->fetch_assoc()) {
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
        // Escreve os dados no CSV
        while ($row = $result->fetch_assoc()) {
            fputcsv($csvFile, $row);
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
    }
    
    $conn->close();
    exit();
} elseif (isset($_POST['grupos'])) {
    // Mapeamento de grupos para nomes de arquivo
    $grupoNomesArquivo = [
        1 => "data_zona1",
        2 => "data_zona2",
        3 => "data_zona3",
        4 => "data_zona4",
        5 => "data_zona5",
        6 => "data_zona6",
        7 => "data_zona7",
        8 => "data_zona8"
    ];
    
    // Processar a geração do CSV aqui
    $gruposSelecionados = $_POST['grupos'];
    
    // Conexão com o banco de dados
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "plantdb";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }
    
    // Consulta SQL para selecionar os sensores dos grupos escolhidos
    // Calcula o tempo atual
    $current_time = date('H:i:s');
    
// Calcula o tempo 24 horas atrás
$twentyFourHoursAgo = date('H:i:s', strtotime('-24 hours'));

// Sua consulta SQL
// Calcula a data e hora de agora
$current_date = date('Y-m-d');
$current_time = date('H:i:s');

// Calcula a data de ontem à mesma hora
$yesterday_date = date('Y-m-d', strtotime('-1 day'));

// Sua consulta SQL
$sql = "SELECT l.grupo,s.hour,s.id_sensor, s.temperature, s.humidity, s.pressure, s.altitude, s.eCO2, s.eTVOC, s.date, s.hour
        FROM location l
        INNER JOIN sensors s ON l.id_sensor = s.id_sensor
        WHERE l.grupo IN (" . implode(',', $gruposSelecionados) . ")
        AND (
            (s.date = '$current_date' AND s.hour <= '$current_time') OR
            (s.date = '$yesterday_date' AND s.hour >= '$current_time')
            )";$result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                // Verifica se o grupo existe no mapeamento
                foreach ($gruposSelecionados as $grupo) {
                    if (array_key_exists($grupo, $grupoNomesArquivo)) {
                        // Nome do arquivo CSV
                        $filename = $grupoNomesArquivo[$grupo] . ".csv";
                        
                        // Cria um arquivo CSV
                        $csvFile = fopen($filename, 'w');
                        
                        $header = ["Grupo","Hora", "ID do Sensor", "Temperatura (°C)", "Umidade (%)", "Pressão (hPa)", "Altitude (m)", "eCO2", "eTVOC"];
                        fputcsv($csvFile, $header);
                        
                    while ($row = $result->fetch_assoc()) {
                        if ($row['grupo'] == $grupo) {
                            // Formate os dados conforme necessário
                            $formattedData = [
                                $row['grupo'],
                                $row['hour'],
                                $row['id_sensor'],
                                $row['temperature'],
                                $row['humidity'],
                                $row['pressure'],
                                $row['altitude'],
                                $row['eCO2'],
                                $row['eTVOC']
                            ];
                            
                            fputcsv($csvFile, $formattedData);
                        }
                    }
                    
                    // Fecha o arquivo CSV
                    fclose($csvFile);
                    
                    // Define os cabeçalhos para download
                    header('Content-Type: text/csv');
                    header('Content-Disposition: attachment; filename="' . $filename . '"');
                    
                    // Lê e envia o arquivo CSV para o cliente
                    readfile($filename);
                } else {
                    echo "Nome do grupo não mapeado para arquivo.";
                }
            }
        } else {
            echo "Nenhum dado encontrado para os grupos selecionados.";
        }
        
        $conn->close();
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <style>
        .container {
            text-align: center;
        }

        .sensor-container {
            background-color: #f2f2f2;
            padding:20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            max-height: 500px;
            overflow-y: auto;
        }

        .form-check {
            margin-bottom: 5px; /* Reduz o espaçamento entre os blocos de seleção */
        }

        .form-check-input {
            margin-right: 5px; /* Reduz o espaçamento entre os checkboxes e os rótulos */
        }

        .btn-primary {
            margin-top: 10px;
        }
          /* Adicione este estilo para espaçamento entre formulários */
          .form-container {
            margin-bottom: 20px; /* Espaçamento entre formulários */
        }

    </style>
    
</head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário para Download de CSV</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href=" https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<body>
    <?php
        include('nav.inc.php');
        ?>
    <div class="container">
        <h1>Selecione os Sensores</h1>
        <form action="" method="post" class="form-container">
        <div class="sensor-container row">
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
            
            // Consulta SQL para obter a lista de sensores
            $sql = "SELECT id_sensor FROM sensors GROUP BY id_sensor";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="col-md-2 form-check">'; // Col-md-4 para criar três colunas
                    echo '<input type="checkbox" class="form-check-input" name="sensores[]" value="' . $row['id_sensor'] . '">';
                    echo '<label class="form-check-label">' . $row['id_sensor'] . '</label>';
                    echo '</div>';
                }
            } else {
                echo "Nenhum sensor encontrado.";
            }
            
            $conn->close();
            ?>
            <button type="submit" class="btn btn-primary mt-3">Gerar CSV</button>    
        </form>
        </div>
        <form action="" method="post" class="form-container">
        <div class="sensor-container row">
            Geração Por Grupos
          <?php
          $servername = "localhost";
          $username = "root";
          $password = "";
          $dbname = "plantdb";
          
          $con1 = new mysqli($servername, $username, $password, $dbname);
          $sql1 = "SELECT grupo,id_sensor FROM location WHERE grupo != '0' GROUP BY grupo;
            ";
            $result1 = $con1->query($sql1);
            
            if ($result1->num_rows > 0) {
                while ($row1 = $result1->fetch_assoc()) {
                    echo '<div class="col-md-2 form-check">'; // Col-md-4 para criar três colunas
                    echo '<input type="checkbox" class="form-check-input grupoCheckbox" name="grupos[]" value="' . $row1['grupo'] . '">';
                    echo '<label class="form-check-label">' . $row1['grupo'] . '</label>';
                    echo '</div>';
                }
            } else {
                echo "Nenhum sensor encontrado.";
            }
            
            $con1->close();
            ?>
             <button type="submit2" class="btn btn-primary mt-3">Gerar CSV por Grupo</button>  
        </form>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const checkboxes = document.querySelectorAll(".grupoCheckbox");

            checkboxes.forEach(function (checkbox) {
                checkbox.addEventListener("change", function () {
                    if (this.checked) {
                        // Desmarcar os outros checkboxes
                        checkboxes.forEach(function (otherCheckbox) {
                            if (otherCheckbox !== checkbox) {
                                otherCheckbox.checked = false;
                            }
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>

<?php
}else{
    header('Location: login.php');
}