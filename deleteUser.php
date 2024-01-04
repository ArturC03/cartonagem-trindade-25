<?php
require_once('db.inc.php');
$id = $_GET['id'];

if (my_query("DELETE FROM users WHERE user_id = $id") === TRUE) {
    header('Location: manageUser.php'); 
    exit;
} else {
    echo "Error deleting record";
}