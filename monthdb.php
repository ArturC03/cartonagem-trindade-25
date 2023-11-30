<?php
    include('connect.inc.php');


    $day= date('d');
    $month= date('m');
    $year= date('y');
    $data= $year."/".$month."/".$day;

    
    $dt = DateTime::createFromFormat('!d/m/Y', $data);
    $dbname= $year."_".strtoupper($dt->format('M'));
    
    $prevday= $day - 1;

    $sql= "NOT EXISTS(SELECT * from $year where name = '$dbname')";
    if($conn->query($sql) === false){
        
        $sql= "create database $dbname";

        if($conn->query($sql) === TRUE){
            echo "base de dados criada.";
        }
        
        $sql= "create table $dbname.location LIKE plantdb.location";
        $conn->query($sql);
        $sql= "INSERT INTO $dbname.location select * from plantdb.location";
        $conn->query($sql);
        $sql= "create table $dbname.users LIKE plantdb.users";
        $conn->query($sql);
        $sql= "INSERT INTO $dbname.users select * from plantdb.users";
        $conn->query($sql);
        $sql= "create table $dbname.sensors LIKE plantdb.sensors";
        $conn->query($sql);

    }
    
    $sql="INSERT INTO $dbname.sensors SELECT * from plantdb.sensors where date <= '20".$year."-".$month."-".$prevday."'";
    $conn->query($sql);
    
    $sql="DELETE from plantdb.sensors where date <= '20".$year."-".$month."-".$prevday."'";
    $conn->query($sql);

    
    

    $conn->close(); 
?>