<?php
include('config.inc.php');

if (isset($_SESSION['username'])) {
  include('header.inc.php');

  $result = $conn->query("SELECT location.id_sensor, sensors.id_sensor FROM location INNER JOIN sensors ON location.id_sensor = sensors.id_sensor WHERE location.status=1 GROUP BY id_sensor
");
?>
    <br>
    <div class="abc" style="padding-top: 0px;">
      <form name="form01" method="POST" action="consultaTabela.php" style="margin-left: 40px; height:710px">
        <label for="sensor" style="margin-top: 0px;">Nós da rede: </label>
        <?php 
			        $consulta = mysqli_query($conn,"SELECT id_sensor FROM location WHERE location.status=1 GROUP BY id_sensor");
			        echo "<br><select name='ids[]' multiple onchange='limitarSelecoes(this, 2)' style='
              margin-left: 2px;'>";
			        while ($resultado = mysqli_fetch_assoc($consulta)) {
                echo "<option value=" . $resultado["id_sensor"] . ">" . $resultado["id_sensor"] . "</option>";
			        }
			        echo "</select>";
			        ?><br>
        <label for="mindata">Data Mínima: </label> <br>
        <input type="date" id="mindata" name="text2" required value="<?php echo date('Y-m-d') ?>"> <br>
        <label for="maxdata">Data Máxima: </label> <br>
        <input type="date" id="maxdata" name="text3" required value="<?php echo date('Y-m-d') ?>"> <br>
        <label for="minhora">Hora Mínima: </label> <br>
        <input type="time" id="minhora" name="hora1"><br>
        <label for="maxhora">Hora Máxima: </label> <br> 
        <input type="time" id="maxhora" name="hora2" > <br><br>
        <input type="reset" id="reset">
        <input type="submit" id="submit" name="submeter">
      </form>
      <div class="imagem">
        <img src="images/plantaV3.png">
      </div>
    </div>
 <script>
  function toggleSelect() {
    var select = document.querySelector('select[name="id[]"]');
    if (select.style.display === 'none') {
      select.style.display = 'block';
    } else {
      select.style.display = 'none';
    }
  }   
</script>
<script>
		function limitarSelecoes(selectElement, maxSelecoes) {
  var selecoes = selectElement.selectedOptions.length;
  if (selecoes > maxSelecoes) {
    for (var i = 0; i < selectElement.options.length; i++) {
      if (!selectElement.options[i].selected) {
        selectElement.options[i].disabled = true;
      }
    }
  } else {
    for (var i = 0; i < selectElement.options.length; i++) {
      selectElement.options[i].disabled = false;
      }
    }
}
</script>
  

<?php
  include('footer.inc.php');  
}else{
  header('Location: login.php');
}