<?php
    include('config.inc.php');

    $ids=$_POST['ids'];
    $sensores= "";
    foreach($ids as $id){
        $sensores= $sensores. "('".$id."',";
    }
    $sensores= substr($sensores, 0, -1);
    $sensores= $sensores.")";

    $dataMinima= "".$_POST["dataMinima"];
    $dataMaxima= "".$_POST["dataMaxima"];
    
    $horaMinima= $_POST["horaMinima"];
    $horaMaxima= $_POST["horaMaxima"];
    
    $timestamp= strtotime($dataMaxima);
    $timestamp2= strtotime($dataMinima);
    
    $dataMinima= date("y-m-d", $timestamp2);
    $dataMaxima= date("y-m-d", $timestamp);
    
    $comprimento= strlen($sensores);

    $comp2= "".strlen($horaMinima);
    $comp3= "".strlen($horaMaxima);
    
    if($comp2==0 && $comp3==0){
        $comp2= "s.hour BETWEEN '00:00' and '23:59' AND ";
    }elseif($comp2==0 && $comp3 <> 0){
        $comp2= "s.hour BETWEEN '00:00' and '".$horaMaxima."' and ";
    }elseif($comp2 <> 0 && $comp3 <> 0){
        $comp2= "s.hour BETWEEN '".$horaMinima."' and '".$horaMaxima."' AND ";
    }else{
        $comp2= "s.hour BETWEEN '".$horaMinima."' and '23:59' AND ";
    }
    
    $datas= "s.date BETWEEN '".$dataMinima."' and '".$dataMaxima."' AND ";        
    
    $timestamp= strtotime($dataMaxima);
    $timestamp2= strtotime($dataMinima);
    
    $diaMinPesquisa= date('d', $timestamp2);
    $mesMinPesquisa= date('m', $timestamp2);
    $anoMinPesquisa= date('y', $timestamp2);
    
    $diaMaxPesquisa= date('d', $timestamp);
    $mesMaxPesquisa= date('m', $timestamp);
    $anoMaxPesquisa= date('y', $timestamp);
    
    $diaAtual= date('d');
    $mesAtual= date('m');
    $anoAtual= date('y');

    $dataAtual= $anoAtual."_".$mesAtual;
    
    if($anoMaxPesquisa == $anoAtual){
      $i= $mesAtual-$mesMaxPesquisa;
    }

    if (isset($_POST['mesMinPesquisa'])) {
        $mesMinPesquisa= $_POST['mesMinPesquisa'];
    }
    if (isset($_POST['anoMinPesquisa'])) {
        $anoMinPesquisa= $_POST['anoMinPesquisa'];
    }

    $mesMaxPesquisa= $mesMaxPesquisa +1;

    while($mesMinPesquisa <> $mesMaxPesquisa || $anoMinPesquisa <> $anoMaxPesquisa) {
        $dataMensal= "20".$anoMinPesquisa."-".$mesMinPesquisa."-01";
        $dataMensal= strtotime($dataMensal);
        
        if ($dataMensal != date("Y-m-d")) {
            $dbname2= $anoMinPesquisa."_".date('M', $dataMensal);
            $mysqli = new mysqli($servername, $username, $password, $dbname2);
            $offset = 0;
        }else {
            $mysqli = new mysqli($servername, $username, $password, $dbname);
        }

        if($mesMinPesquisa == 12){
            $anoMinPesquisa++;
            $mesMinPesquisa = 0;
        }
        
        $sql = "SELECT distinct s.* FROM sensors s where ".$comp2.$datas."s.id_sensor in $sensores order by date ASC";
        $result = my_query($sql . " LIMIT 100 OFFSET $offset;");
        $offset = $offset + count($result);
        if (sizeof($data) >= 100) {
            foreach ($result as $row) {
                $data["sql"][] = $row;
            }
            $data["mesMinPesquisa"] = $mesMinPesquisa;
            $data["anoMinPesquisa"] = $anoMinPesquisa;
            $data["offset"] = $offset;
            echo json_encode($data);
            exit(0);
        }

        $mesMinPesquisa++;
    }