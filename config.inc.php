<?php
@session_start();

include('connect.inc.php'); 

$sql = "SELECT titulo from titulo WHERE id=(select max(id) from titulo);";  
      
$result = $mysqli->query($sql);
while($row = mysqli_fetch_array($result)){
  $site_title = $row['titulo'];
}