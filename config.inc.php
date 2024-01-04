<?php
@session_start();

include('connect.inc.php');

$sql = "SELECT titulo from titulo WHERE id=(select max(id) from titulo);";

$result = $mysqli->query($sql);
while($row = mysqli_fetch_array($result)){
  $site_title = $row['titulo'];
}

$viewportWidth = 0.62;

if (!isset($_SESSION['screenWidth'])) {
  echo "<script src='https://code.jquery.com/jquery-3.7.1.min.js' integrity='sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=' crossorigin='anonymous'></script>";
  echo "<script src='js/setScreenWidth.js'></script>";
}

$viewportWidthPixels = $_SESSION['screenWidth'] * $viewportWidth;

$originalImageWidth = getimagesize('images/plantaV3.png')[0];
$originalImageHeight = getimagesize('images/plantaV3.png')[1];

$heightInPixels = ($viewportWidthPixels / $originalImageWidth) * $originalImageHeight;
