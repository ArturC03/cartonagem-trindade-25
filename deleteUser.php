<?php
include('php/connect.php');
$id = $_GET['id'];


$mysqli = new mysqli($servername, $username, $password, $dbname);


if ($mysqli->connect_errno) {
					echo "<p>MySQL error no {$mysqli->connect_errno} : {$mysqli->connect_error}</p>";
					exit();
				} 
				
$sql = "DELETE FROM users WHERE user_id = $id"; 

if (mysqli_query($mysqli, $sql)) {
    mysqli_close($mysqli);
    header('Location: manageUser.php'); 
    exit;
} else {
    echo "Error deleting record";
}			

?>