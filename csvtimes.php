<?php
include('config.inc.php');

if (isset($_SESSION['username'])) {
    include('header.inc.php');
?>
<div class="container">   
<div class="sensor-container row">
<p>Grupos</p>
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
            $sql = "SELECT location.grupo, location.id_sensor, sensors.id_sensor FROM location INNER JOIN sensors ON location.id_sensor = sensors.id_sensor where location.gerar=1 group by sensors.id_sensor ";
            
            $result = $conn->query($sql);
            
            // Um array para armazenar os grupos e seus sensores
            $gruposSensores = array();
            
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $grupo = $row["grupo"];
                    $sensor = $row["id_sensor"];
                    
                    // Verifica se o grupo já existe no array
                    if (!isset($gruposSensores[$grupo])) {
                        $gruposSensores[$grupo] = array();
                    }
                    
                    // Adicione o sensor ao grupo
                    $gruposSensores[$grupo][] = $sensor;
                }
            }
            
            echo '<table border="1">';
            echo '<tr><th>Grupo</th><th>Sensores</th></tr>';
            
            foreach ($gruposSensores as $grupo => $sensores) {
                echo '<tr>';
                echo '<td>' . $grupo . '</td>';
                echo '<td>' . implode(", ", $sensores) . '</td>';
                echo '</tr>';
            }
            
            echo '</table>';
            
            ?>    
    </div> 
    <br>
        <form action="gerar_csv.php" method="post" class="form-container">
        <div class="sensor-container row">
            Selecione o grupo<br>
            <select name="grupo">
            <option value="1">Grupo 1</option>
            <option value="2">Grupo 2</option>
            <option value="3">Grupo 3</option>
            <option value="4">Grupo 4</option>
            <option value="5">Grupo 5</option>
            <option value="6">Grupo 6</option>
            </select>
            <div class="sensor-update row">
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
            $sql1 = "SELECT id_sensor FROM sensors GROUP BY id_sensor";
            $sql = "SELECT  location.id_sensor, location.location_x,location.location_y, CAST(CONV(RIGHT(sensors.id_sensor, 2), 16, 10) AS SIGNED) AS id_sensor_decimal,sensors.Active
        FROM 
            location
        INNER JOIN 
            sensors 
        ON 
            location.id_sensor = sensors.id_sensor
            where location.grupo=$grupo GROUP BY location.id_sensor";
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
                echo "Nenhum sensor encontrado.";
            }
            
            $conn->close();
            
            ?>          
            </div>
            <p>Hora a definir</p>
            <input type="datetime-local"style="width:123px" name="horaSelecionada" id="horaSelecionada" step="1">  
           <button type="submit" class="btn btn-primary mt-3" id="meuBotao">Agendar CSV</button>      
    </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Função para carregar a lista de sensores ao carregar a página
    function loadSensorList(grupo) {
        $.ajax({
            type: 'POST',
            url: 'atualizar_sensores.php',
            data: { grupo: grupo },
            success: function(response) {
                $('.sensor-update').html(response);
            }
        });
    }

    // Carregar a lista de sensores quando a página for carregada
    loadSensorList($('select[name="grupo"]').val());

    // Lidar com a mudança na seleção de grupo
    $('select[name="grupo"]').change(function() {
        var selectedGrupo = $(this).val();
        loadSensorList(selectedGrupo);
    });
});
</script>
<?php
    include('footer.inc.php');
}else{
    header('Location: login.php');
}