<?php
include('config.inc.php');

if (isset($_SESSION['username'])) {
    include('header.inc.php');

    if (isset($_POST['submit'])) {
        $sensoresSelecionados = $_POST['sensores'];
        $folderName = rand(100000, 999999);

        while (file_exists('download/scheduled/' . $folderName)) {
            $folderName = rand(100000, 999999);
        }

        $result = my_query("INSERT INTO hora (id_hora, hora_geracao, sensores, tipo_geracao) VALUES (" . $folderName . " ,'" . $_POST['horaSelecionada'] . "', '" . implode(",", $sensoresSelecionados) . "', " . $_POST['submit'] == "CSV" ? '0' : '1' . ");");

        mkdir('download/scheduled/' . $folderName, 0777, true);

        exec('schtasks /create /sc ' . $_POST['periodoSelecionado'] . ' /tn "CSV Agendado" /tr "C:\xampp\php\php.exe 
        scheduled.php?submit=' . $_POST['submit'] . '&sensores=' . implode(",", $sensoresSelecionados) . '&periodoSelecionado=' . $_POST['periodoSelecionado']
        . (isset($_POST['horaSelecionada']) ? '&horaSelecionada=' . $_POST['horaSelecionada'] . '" /st ' . $_POST['horaSelecionada'] : '"') . ' /f');
    }
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
        <div class="sensor-container2">
            <div class="sensors-select">
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
                <p>Tipo de Agendamento</p>
                <select name="periodoSelecionado" id="periodo" required>
                    <option value="">Selecione uma opção</option>
                    <option value="ONCE">Data Definida</option>
                    <option value="MINUTE">Minuto a Minuto</option>
                    <option value="HOURLY">Hora a Hora</option>
                    <option value="DAILY">Diariamente</option>
                    <option value="WEEKLY">Semanalmente</option>
                    <option value="MONTHLY">Mensalmente</option>
                </select>

                <input type="datetime-local" name="horaSelecionada" id="hora" disabled>
                
                <div class="button-container">
                    <button type="submit" class="btn-success" name="submit" id="BotaoCSV" value="CSV">Agendar CSV</button>
                    <button type="submit" class="btn-success" name="submit" id="BotaoJSON" value="JSON">Agendar JSON</button>
                </div>
            </div>
            <div class="scheduled">
                <h2>Agendamentos</h2>

                <section class="table_body">
                    <?php
                        $result = my_query("SELECT * FROM hora ORDER BY hora_geracao;");

                        echo '<table>';
                        echo '<thead>';
                        echo '<tr><th>Data e Hora</th><th>Sensores</th></tr>';
                        echo '</thead>';
                        
                        echo '<tbody>';
                        foreach ($result as $row) {
                            echo '<tr>';
                            echo '<td>' . $row["id_hora"] . '</td>';
                            echo '<td>' . $row["hora_geracao"] . '</td>';
                            echo '</tr>';
                        }

                        echo '</tbody>';
                        echo '</table>';
                    ?>
                </section>
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