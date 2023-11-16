<?php
/**
 * Returns the list of sensors.
 */
require 'connect.php';
error_reporting(0); 

$sql = "SELECT * FROM sensors where id_sensor='0101'  LIMIT 8";

try {
    $result = $con->query($sql);
} catch (Exception $ex) {
    die('Query Error!');
}
//Close connection
$conn->close();

include 'sensors.php';