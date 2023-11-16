<?php 
//ini_set('display_errors', 0);
     $servername = "localhost";
     $username = "root";
     $password = "";
     $dbname = "plantdb";



  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
 // Check connection
 if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$id_exists = false;
$id_sensor = $_GET['id'];
$location_x = $_POST['location_x'] ; 
$location_y = $_POST['location_y'] ; 
$sqlCheck = "SELECT id_sensor FROM location WHERE id_sensor='$id_sensor'";
$res=mysqli_query($conn,$sqlCheck);


if (mysqli_num_rows($res) > 0)
{
  $sql="UPDATE `location` SET `location_x`='$location_x',`location_y`='$location_y' where `id_sensor` = '$id_sensor';";

   if ($conn->query($sql) === TRUE) {
   echo "Localização Atualizada com Sucesso";
  } else {
  echo "Error: " . $sql . "<br>" . $conn->error;
} 

}

else if (mysqli_num_rows($res) == 0)
{

  $sql = "INSERT INTO location (location_x, location_y, id_sensor) VALUES 
  ('$location_x', '$location_y','$id_sensor' )";

  if ($conn->query($sql) === TRUE) {
   echo "Nova localização adicionada com sucesso!!";
  } else {
  echo "Error: " . $sql . "<br>" . $conn->error;
} 

}


 



$conn->close();