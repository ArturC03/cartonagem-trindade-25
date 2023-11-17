<?php
include('connect.php');
$id = $_GET['id'];
$status = $_GET['status'];
echo "Id: $id  Status: $status ";

$mysqli = new mysqli($servername, $username, $password, $dbname);


if ($mysqli->connect_errno) {
					echo "<p>MySQL error no {$mysqli->connect_errno} : {$mysqli->connect_error}</p>";
					exit();
				} 


 if($status == 1 ){
    $sql = "update `location` set status = 0 WHERE id_sensor = '$id'"; 
    mysqli_query($mysqli, $sql);
    mysqli_close($mysqli);
    header('Location: manageSensors.php'); 
    exit;
} elseif($status == 0 ) {
    $sql = "update `location` set status = 1 WHERE id_sensor = '$id' "; 
    mysqli_query($mysqli, $sql);
    mysqli_close($mysqli);
    header('Location: manageSensors.php'); 
    exit;
} else{
    echo "Primeiro é necessário definir uma localização!!";
} 
?>