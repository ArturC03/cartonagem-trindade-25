<?php
@session_start();

include('connect.inc.php'); 

$mysqli = new mysqli("$servername", "$username", "$password", "$dbname");
if ($mysqli->connect_errno) { 
  echo "<p>MySQL error no {$mysqli->connect_errno} : {$mysqli->connect_error}</p>";
  exit();
}
$sql = "SELECT titulo from titulo WHERE id=(select max(id) from titulo);";  
      
$result = $mysqli->query($sql);
while($row = mysqli_fetch_array($result)){
  $site_title = $row['titulo'];
}