<?php
include('connect.inc.php');
$id = $_GET['id'];

$sql = "DELETE FROM users WHERE user_id = $id"; 

if (mysqli_query($mysqli, $sql)) {
    mysqli_close($mysqli);
    header('Location: manageUser.php'); 
    exit;
} else {
    echo "Error deleting record";
}			

?>