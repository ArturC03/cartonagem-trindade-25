<?php
include('include/config.inc.php');
$id = $_GET['id'];

if (my_query("DELETE FROM users WHERE user_id = $id") == TRUE) {
    header('Location: manageUser.php'); 
    exit;
} else {
    echo "Erro a eliminar utilizador! Tente outra vez!";
}