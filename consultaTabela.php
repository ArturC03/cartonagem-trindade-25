<!DOCTYPE html>
<meta charset="utf-8">
<html >
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href=" https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

<?php

include('nav.php');
include('dados.php');

//ver sombra do form
?>
<html>
  
  <style>
  
    #tableSensors {
        font-size: 14px; /* Adjust the font size as needed */
        margin-top: -20px; /* Adjust the margin as needed */
    }

    #tableSensors thead th,
    #tableSensors tbody td {
        padding: 6px 8px; /* Adjust the padding as needed */
    }

    #tableSensors_wrapper {
        max-width: 100%; /* Limit the width of the table container to the available width */
     
    }

   

   
    /* 64ac15 */
*,
*:before,
*:after {
  box-sizing: border-box;
}
td {
    width: 1px;
    white-space: nowrap;
}
.botao{
  float: right;
  margin-right: 3vh;
  margin-left: 20px;
  display: inline-block;
}

#alterarVista{
  width: 50px;
  height: 50px;
  background: url(images/graf.ico);
  border: 1px solid #B4BBBB;
  border-radius: 3px;
  box-shadow: 0px 0px 1px lightgrey;
  display: block;
}
#botaoBack{
  margin-top: 10px;
  width: 50px;
  height: 50px;
  background: url(images/back.png);
  border: 1px solid #B4BBBB;
  border-radius: 3px;
  box-shadow: 0px 0px 1px lightgrey;
  display: block;

}
#botaodown{
  width: 50px;
  height: 50px;
  background: url(images/down_3.png);
  border: 1px solid #B4BBBB;
  border-radius: 3px;
  box-shadow: 0px 0px 1px lightgrey;
  margin-top: 10px;
  display: block;

}

#alterarVista:hover{
  box-shadow: 0px 0px 5px grey;
}
#alterarVista:focus{
  outline: none;
}
#tableSensors_wrapper{
  height: 500px;
  margin-top: -50px; /* Adjust the value to move the table up (negative value moves it up) */
  padding: 0;
}

    </style>    
    <body>
    <?php
    $id1=null;
    $id2=null;
    $id3=null;
    if(isset($_POST["ids"])){ 
        $idsSelecionados = $_POST["ids"]; // array de IDs selecionados
        $numIdsSelecionados = count($idsSelecionados); // número de IDs selecionados
      
        // armazenar os IDs individualmente em variáveis
        if($numIdsSelecionados >= 1){
          list($id1) = $idsSelecionados;
        }
        if($numIdsSelecionados >= 2){
          list($id1, $id2) = $idsSelecionados;
        }
        if($numIdsSelecionados >= 3){
          list($id1, $id2, $id3) = $idsSelecionados;
        }
      }
      ?>
    <?php
    $sensores= "('$id1', '$id2', '$id3')";
    $comp2= $_GET['bbbb'];
    $datas= $_GET['cccc'];
    //$dbname2= $_GET['dddd'];
    $dataMinima= $_GET['eeee'];
    $dataMaxima= $_GET['ffff'];

      if(isset($_POST['submeter'])){
        $sensores= "('$id1', '$id2', '$id3')";
        $sensor=$_POST["text1"];
        $dataMinima= "".$_POST["text2"];
        $dataMaxima= "".$_POST["text3"];
    
        $horaMinima= $_POST["hora1"];
        $horaMaxima= $_POST["hora2"];
    
        $timestamp= strtotime($dataMaxima);
        $timestamp2= strtotime($dataMinima);

        $dataMinima= date("y-m-d", $timestamp2);
        $dataMaxima= date("y-m-d", $timestamp);
    
        $comprimento= strlen($sensores);
    
        If($comprimento==3){
          $sensores= "";
        }
        
    
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

        
        //echo $dbname2;

        //dados($sensores, $comp2, $datas);

    }
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
    
    //$dbname2= $anoPesquisa."_".$mesPesquisa;
    $dataAtual= $anoAtual."_".$mesAtual;

    if($anoPesquisa == $anoAtual){
      $i= $mesAtual-$mesPesquisa;
    }
      
      //$comp2= "s.hour BETWEEN '00:00' and '23:59' AND ";
      //$datas= "s.date BETWEEN '2023-01-03' and '2023-01-03' AND "

    

        // tecla maior
        
        
        
        ?>
        <br>
        <br>
        <br>  
        
        <div class="botao">
          <button id="alterarVista" name="botaoAlterarVista" value="submeter" class="button" onclick="altera2()"></button>
      
          <a href="dados.csv" download><button type="button" id="botaodown" class="button"></button></a>
               
<button id="botaoBack" type="button" name="botaoBack" class="button" onclick="back()"></button><br>

        </div>
        
        <div class="container" style="
    margin-left: -30;
    margin-left: 0px;
    margin-right: -50;
    margin-right: 70px;
    padding-right: 0px;
    padding-left: 0px;
    ">          <table  id="tableSensors" class="table table-striped table-bordered" style="border: 0px;">  
            <thead class="thead-dark">  
              <tr>    
                <th>Id</th>
                <th>Hora</th>
                <th>Data</th>
                <th>Temperatura(°C)</th>
                <th>Humidade(%)</th>
                <th>Pressão(HPA)</th>
                <th>CO2(PPM)</th>
                <th>TVOC(PPB)</th>
              </tr>  
            </thead>  
          
          
            <tbody> 
              <?php  

              require 'php/connect.php';
              //error_reporting(0); 
              $mysqli = new mysqli("$servername", "$username", "$password", "$dbname");
            
              if ($mysqli->connect_errno) {
                echo "<p>MySQL error no {$mysqli->connect_errno} : {$mysqli->connect_error}</p>";
                exit();
              }
              
              $mesMaxPesquisa= $mesMaxPesquisa +1;

              while($mesMinPesquisa <> $mesMaxPesquisa){
              
              $dataMensal= "20".$anoMinPesquisa."-".$mesMinPesquisa."-01";
              $dataMensal= strtotime($dataMensal);
              
              $dbname2= $anoMinPesquisa."_".date('M', $dataMensal);
              

              if($mesMinPesquisa == 12){
                $anoMinPesquisa++;
                $mesMinPesquisa = 0;
              }

              
              //$sql = "SELECT s.* FROM `sensors` s, `location` l where s.id_sensor = l.id_sensor and l.status = 1 order by sensor_id DESC;";
              $sql = "SELECT distinct s.* FROM $dbname2.sensors s where ".$comp2.$datas."s.id_sensor in $sensores order by date ASC;";
              
              //'".$horaMinima."' and '".$horaMaxima."' and
              $result = $mysqli->query($sql);
              
              while($row = mysqli_fetch_array($result))  
              { 
              
                echo '  
                <tr *ngFor="let sensor of sensorInfo.data |filter : term| paginate: { itemsPerPage: 4, currentPage: p }">  
                <td>'. $row["id_sensor"]. '</td>
                <td>'. $row["hour"]. ' </td>
                <td>'. $row["date"]. ' </td>
                <td>'. ltrim($row["temperature"],'0'). '</td>
                <td>'. ltrim($row["humidity"],'0'). ' </td>
                <td>'. ltrim($row["pressure"],'0'). ' </td>
                <td>'. ltrim($row["eCO2"],'0'). ' </td>
                <td>'. ltrim($row["eTVOC"],'0'). ' </td>
                ';              
              }
             
              if($diaMaxPesquisa == $diaAtual){
                $sql = "SELECT distinct s.* FROM plantdb.sensors s where ".$comp2.$datas."s.id_sensor in $sensores order by date ASC;";
                //'".$horaMinima."' and '".$horaMaxima."' and
                $result = $mysqli->query($sql);
              
                while($row = mysqli_fetch_array($result))  
                { 
              
                echo '  
                <tr *ngFor="let sensor of sensorInfo.data |filter : term| paginate: { itemsPerPage: 4, currentPage: p }">  
                <td>'. $row["id_sensor"]. '</td>
                <td>'. $row["hour"]. ' </td>
                <td>'. $row["date"]. ' </td>
                <td>'. ltrim($row["temperature"],'0'). '</td>
                <td>'. ltrim($row["humidity"],'0'). ' </td>
                <td>'. ltrim($row["pressure"],'0'). ' </td>
                <td>'. ltrim($row["eCO2"],'0'). ' </td>
                <td>'. ltrim($row["eTVOC"],'0'). ' </td>
                ';
                }        
              }
              $mesMinPesquisa++;
              }
              
              $sq1="SELECT id_sensor,hour,date,temperature,humidity,pressure,eCO2,eTVOC from sensors where id_sensor in $sensores order by date ASC";
              $result2=mysqli_query($conn,$sq1);
              $fileName = 'dados.csv';
              // Abre o arquivo para escrita
              $file = fopen($fileName, 'w');
              fputcsv($file, array('id_sensors', 'Hora', 'Data', 'Temperatura', 'Humidade','Pressão','CO2','TVOC'),';');
              while ($row = mysqli_fetch_array($result2,MYSQLI_NUM)) {
                $formattedTemperature = ltrim(sprintf("%.3f", $row[3]), '0');
    $row[3] = $formattedTemperature;
    $formattedHumidity = ltrim(sprintf("%.3f", $row[4]), '0');
    $row[4] = $formattedHumidity;

    // Formata a pressão
    $formattedPressure = ltrim(sprintf("%.3f", $row[5]), '0');
    $row[5] = $formattedPressure;

                fputcsv($file, $row,';');
              }
              fclose($file);
              header('Content-Type: text/csv');
              header('Content-Disposition: attachment; filename="' . $fileName . '"');
            

              ?> 
            </tbody>  
          </table>  
          
          <table cellspacing="0" cellpadding="0" border="">
            <tbody>
              <tr>
                <td class="gutter">
                  <div class="line number1 index0 alt2" style="display: none;">1</div>
                </td>
                <td class="code">
                  <div class="container" style="display: none;">
                    <div class="line number1 index0 alt2" style="display: none;">&nbsp;</div>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        <br>
        </div>
        <br>
          
        </body>
        

    <script>
    function altera2(){
      
      window.location.href = "consultaGraficos.php?sensor=<?php echo urlencode($sensores);?>";
      
    
    } 
    function back(){
      
      window.location.href = "archive2.php"; //archive2.php é a ultima versão do arquivo archive
    }
    $(document).ready(function() {
    $('#tableSensors').DataTable(
    {
      searching: false,
      pageLength: 16,
      lengthMenu: false,
      "language": {
        "lengthMenu": "",
        "zeroRecords": "Nothing found - sorry",
        "info": "página _PAGE_ de _PAGES_",
        "infoEmpty": "No records available",
        "infoFiltered": "(filtered from _MAX_ total records)",
        "paginate": {
          "first":      "First",
          "last":       "Last",
         "next":       "próxima",
        "previous":   "anterior"
        }
      }
    }
    );

  } );
    </script>
    
    </body>
</html>


<!--"language": {
        "lengthMenu": "Ver _MENU_ registos por página",
        "zeroRecords": "Nothing found - sorry",
        "info": "página _PAGE_ de _PAGES_",
        "infoEmpty": "No records available",
        "infoFiltered": "(filtered from _MAX_ total records)",
        "paginate": {
          "first":      "First",
          "last":       "Last",
         "next":       "próxima",
        "previous":   "anterior"
        }
      }