<!DOCTYPE html>

<html >
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/sensors.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href=" https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
  <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
</head>
<style>
.asd{
  margin-left: 50px;
  margin-top: 50px;
  padding: 50px;
  padding-top: 40px;
  padding-bottom: 45px;
  float: left;
  border-radius: 15px;
  background: #8d8d8d;
  box-shadow: 0px 0px 20px;
}
label{
  font-size: 15pt;
  font-weight: bold;
  color: black;
  width: 300px;
}
#tit{
  width: 400px;
  border-radius: 10px;
  height: 40px;
  border-color: lightgrey;
  box-shadow: 0px 0px 5px;
  background: lightgrey;
}
input[type="reset"]{
  height: 35px;
  width: 90px;
  border-radius: 10px;
  border-color: white;
  box-shadow: 0px 0px 15px;
}
input[type="reset"]:hover{
  height: 35px;
  width: 90px;
  border-radius: 10px;
  border-color: lightgrey;
  box-shadow: 0px 0px 15px;
  background: lightgrey;
}
input[type="submit"]{
  height: 35px;
  width: 90px;
  border-radius: 10px;
  border-color: white;
  box-shadow: 0px 0px 15px;
  margin-left: 220px;

}
input[type="submit"]:hover{
  height: 35px;
  width: 90px;
  border-radius: 10px;
  border-color: lightgrey;
  box-shadow: 0px 0px 15px;
  background: lightgrey;
}
#voltar{
  width: 100%;
  margin-left: 30px;  
  background: white;
  padding: 20px; 
  padding-top: 7px; 
  padding-bottom: 7px;
  border-radius: 10px;
  box-shadow: 0px 0px 15px;
  color: black;
}
#voltar:hover{
  width: 100%;
  margin-left: 30px;  
  background: lightgrey;
  padding: 20px; 
  padding-top: 7px; 
  padding-bottom: 7px;
  border-radius: 10px;
  box-shadow: 0px 0px 15px;
  color: black;
  text-decoration: none;
}
p{
  margin-left: 30px;
  font-size: 15pt;  
  font-weight: bold;
}
</style>
<body>
<?php
//ini_set('display_errors', 0);
//error_reporting(0);

include('nav.php');

include('php/session.php');

if(isset($_POST['submeter2'])){
  require('connect.php');
  $tit= $_POST['tit'];

  $mysqli = new mysqli("$servername", "$username", "$password", "$dbname");
  if ($mysqli->connect_errno) { 
    echo "<p>MySQL error no {$mysqli->connect_errno} : {$mysqli->connect_error}</p>";
    exit();
  }

  $sql = "INSERT into titulo values(null, '$tit');";  
  $conn->query($sql);
  if ($conn->query($sql) === TRUE) {
    echo "<br><p>Titulo atualizado.</p>";
  } else {
    echo "Erro na criação de novo título! Tente outra vez! "  . $conn->error;
  } 

  echo "<br><br><a id='voltar' href='home.php'> Voltar </a>";
}else{

?>


<div class="asd">
  <form name="form01" method="POST" action="editarTitulo.php">
    <label for="tit">Novo Título: </label> <br>
    <input type="text" id="tit" name="tit" required placeholder="Título"> <br>
    <input type="reset" id="reset">
    <input type="submit" id="submit" name="submeter2">
  </form>
</div>
<?php
}
?>
</body>


