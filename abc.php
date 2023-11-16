<?php
    require('php/connect.php');


    $day = date('d');
    $month = date('m');
    $year = date('y');
    


    //$now= time();
    //$date= strtotime("+15 days", $now);
    //$outro = date("-m-d", $date);
    //echo $outro;

    $mysqli = new mysqli("$servername", "$username", "$password", "$dbname");

    if ($mysqli->connect_errno) {
     echo "<p>MySQL error no {$mysqli->connect_errno} : {$mysqli->connect_error}</p>";
     exit();
    }



    while($day < 31){
        if($month == 1){
            
        }
        if($month == 3){
            
        }
        if($month == 5){
            
        }
        if($month == 7){
            
        }
        if($month == 10){
            
        }
        if($month == 12){
            
        }
    }
    while($day < 30){
        if($month == 4){

        }
        if($month == 6){

        }
        if($month == 9){

        }
        if($month == 11){

        }
    }
    while($day < 28){
        if($month == 2s){

        }
    }




?>