<?php
@session_start();

include('connect.inc.php');

$sql = "SELECT titulo from titulo WHERE id=(select max(id) from titulo);";

$result = $mysqli->query($sql);
while($row = mysqli_fetch_array($result)){
  $site_title = $row['titulo'];
}

$viewportWidth = 0.62;
$viewportWidthPixels = 1666 * $viewportWidth; //SUBSTITUIR COM JS PARA OBTER O TAMANHO DA TELA

$originalImageWidth = getimagesize('images/plantaV3.png')[0];
$originalImageHeight = getimagesize('images/plantaV3.png')[1];

$heightInPixels = ($viewportWidthPixels / $originalImageWidth) * $originalImageHeight;
