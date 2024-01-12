<?php
include('config.inc.php');

if (isset($_SESSION['username'])) {
    include('header.inc.php');
?>
<div class="container">   
    <div class="sensor-container">
        <h2>Grupos</h2>
        <section class="table_body">
        <?php
            $result = my_query("SELECT grupos.id_grupo, grupos.grupo, GROUP_CONCAT(DISTINCT id_sensor) AS id_sensors FROM location, grupos WHERE location.grupo = grupos.id_grupo GROUP BY grupo;");
            
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
    <form action="gerar_csv.php" method="post">
        <div class="sensor-container">
            <h2>Selecione o grupo</h2>
            <select name="grupo">
                <?php
                foreach ($grupos as $k => $v) {
                    echo '<option value="' . $k . '">Grupo ' . $v . '</option>';
                }
                ?>
            </select>
            <div class="sensor-update">          
            </div>
            <p>Hora a definir</p>
            <input type="datetime-local" name="horaSelecionada" id="horaSelecionada" step="1" required>

            <div class="button-container">
                <button type="submit" class="btn-success" id="BotaoCSV">Agendar CSV</button>
                <button type="submit" class="btn-success" id="BotaoJSON">Agendar JSON</button>
            </div>
        </div>
    </form>
</div>
    <script src="js/csvtools.js"></script>
<?php
    include('footer.inc.php');
}else{
    header('Location: login.php');
}