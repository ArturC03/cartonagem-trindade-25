<?php
include('config.inc.php');

if (isset($_SESSION['username'])) {
  include('header.inc.php');

if(isset($_POST['submeter2'])){
  require('connect.inc.php');
  $site_title = $_POST['tit'];
  
  $sql = "INSERT into titulo values(null, '$site_title');";  
  $mysqli->query($sql);
  if ($mysqli->query($sql) === TRUE) {
    echo "<br><p>Titulo atualizado.</p>";
  } else {
    echo "Erro na criação de novo título! Tente outra vez! "  . $mysqli->error;
  } 
  
  echo "<br><br><a id='voltar' href='home.php'> Voltar </a>";
}else{
  
  ?>


<div class="asd">
  <form name="form01" method="POST" action="editarTitulo.php">
    <label for="tit">Novo Título: </label> <br>
    <input type="text" id="tit" name="tit" required placeholder="Título" maxlength="30"> <br>
    <input type="reset" id="reset">
    <input type="submit" id="submit" name="submeter2">
  </form>
</div>
<?php
}
?>
</body>

<?php
  include('footer.inc.php');
}else{
  header('Location: login.php');
}