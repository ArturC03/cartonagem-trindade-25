<!DOCTYPE html>
<meta charset="utf-8">
<html>
<link rel="stylesheet" type="text/css" href="css/sensors.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/Chart.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.min.js" integrity="sha512-UXumZrZNiOwnTcZSHLOfcTs0aos2MzBWHXOHOuB0J/R44QB0dwY5JgfbvljXcklVf65Gc4El6RjZ+lnwd2az2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-zoom/1.0.1/chartjs-plugin-zoom.min.js" integrity="sha512-b+q5md1qwYUeYsuOBx+E8MzhsDSZeoE80dPP1VCw9k/KA9LORQmaH3RuXjlpu3u1rfUwh7s6SHthZM3sUGzCkA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<?php

include('nav.php');


?>

<style type="text/css">
.buttonSensor.selected{
    background-color: lightgrey;
    color: black; 
    border:   2px solid #555555;
}
.buttonSensor:hover{
    background: grey;
}
.botao{
  float: right;
  margin-right: 30px;
  margin-top: 30px;
}
.botaoVista{
  width: 40px;
  height: 40px;
  background: url(images/tabela.ico);
  border: 1px solid #B4BBBB;
  border-radius: 3px;
  box-shadow: 0px 0px 1px lightgrey;
  margin-bottom: 35px;
}

.botaoBack{
  width: 40px;
  height: 40px;
  background: url(images/back_1.ico);
  border: 1px solid #B4BBBB;
  border-radius: 3px;
  box-shadow: 0px 0px 1px lightgrey;
  margin-bottom: 25px;
  margin-left: 10px;
}
.botaoVista:hover{
  box-shadow: 0px 0px 5px grey;
}
.botaoBack:hover{
  box-shadow: 0px 0px 5px grey;
}
.botaoVista:focus{
  outline: none;
}
.botaoBack:focus{
  outline: none;
}
.no{
  text-align: center;
}
.aaa{
  float: left;
  font-size: 25pt;
  font-weight: bold;
  margin-left: 30px;
  position: absolute;
  top: 85px; 
}
body{
  padding: 0;
  margin: 0;
  overflow-x: hidden;
  font-family: sans-serif;

}
.bbb{
  margin-right: 0;
}
.dashboard-container{
  width: 170%;
}

.dadosRecentesTemp{
  position: absolute;
  top: 20px;
  left: 240px;  
}
.dadosRecentesHum{
  position: absolute;
  top: 19px;
  left: 215px;  
}
.dadosRecentesPressao{
  position: absolute;
  top: 17px;
  margin-left: 170px;  
}
.dadosRecentesTC02{
  position: absolute;
  top: 17px;
  left: 215px;  
}
.dadosRecentesTVOC{
  position: absolute;
  top: 17px;
  margin-left: 220px;  
}
.ValueSize{
  font-size: 25pt;  
}
.botaoResetZoom{
  width: 40px;
  height: 40px;
  background: url(images/reload-icon.png);
  border: 1px solid #B4BBBB;
  border-radius: 3px;
  box-shadow: 0px 0px 1px lightgrey;
  margin-bottom: 35px;
  margin-left: 10px;
}
.botaoResetZoom:hover{
  box-shadow: 0px 0px 5px grey;
}
.botaoResetZoom:focus{
  outline: none;
}

</style>  
<body>
 
    <div class="botao">
      <button class="botaoVista" type="button" name="botaoAlterarVista" onclick="altera()">
      <button class="botaoResetZoom" type="button" name="botaoResetZoom" id="botaoResetZoom" onClick="resetZoom()">
      <button class="botaoBack" type="button" name="botaoBack" onclick="back()">


      <!--<button class="botaoBack" id="0102" type="button" name="botaoBack" onclick="SeeSensor(this.id)">-->
    </div>
    
  <div class="container-fluid page-container" style="margin: 0px;">
      <div class="no">
        <br>
        <?php
    
        require 'php/connect.php';
        //error_reporting(0); 
        $mysqli = new mysqli("$servername", "$username", "$password", "$dbname");
        
        if ($mysqli->connect_errno) { 
          echo "<p>MySQL error no {$mysqli->connect_errno} : {$mysqli->connect_error}</p>";
          exit();
        }

        $a= $_GET['sensor'];
        $b= $_GET['comp'];
        $c= $_GET['data'];
        $e= $_GET['dataMin'];
        $f= $_GET['dataMax'];
        
      

        $g= substr($a, 2);
        $g= substr($g, 0, -10);

        ?>

        <?php

        $timestamp= strtotime($e);
        $diaMin= date('d', $timestamp);

        $timestamp2= strtotime($f);
        $diaMax= date('d', $timestamp2);
        
        $i= 0;

        while($diaMin <= $diaMax){
          $strdate[$i]= $diaMin;

          $i++;
          $diaMin++;
        }
        $strdate= implode(", ", $strdate);

        $sql = "SELECT distinct id_sensor FROM `location` where id_sensor = ".$g." order by id_sensor;";  

        $result = $mysqli->query($sql);
        //$sensorId = sensorId;
        while($row = mysqli_fetch_array($result))  
        {  
          
          echo "<div class='aaa' id='$g' onclick='SeeSensor(this.id)'>";
          echo 'Nó '. $row["id_sensor"];
          echo "</div>";


        }
        
        ?>
        <br>
      </div>
    <div class="row dashboard-container">
      <div class="col-10">
        <div class="row dashboard-rows">
          <div class="col-md-9 pr-md-1">
            <div class="graph-containers" style="width: 100%;">
              <br>
              <h3 style="margin-left: 1%;"><img class="img-responsive" src="images/temperature.png" alt="" width="40px" style="margin-bottom: 10px;"/>Temperatura - </h3>
              <div class="dadosRecentesTemp">
                <p class="ValueSize" id="Temp_actual"> °C</p>
              </div>
              <canvas id='canvasTemp' height="35"> {{ chart }}</canvas>
            </div>
          </div>
      </div>
        <div class="row dashboard-rows">
            
            <div class="col-md-9 pr-md-1">
                <div class="graph-containers" style="float: left; width: 49%;">
                    <br>
                    <h3 style="margin-left: 2%;"> <img class="img-responsive" src="images/humidity.png" alt="" width="35px" style="margin-bottom: 10px; margin-right: 5px;">Humidade - </h3>
                    <div class="dadosRecentesHum">
                      <p class="ValueSize" id="Hum_actual"> %</p>
                    </div>
                    <canvas id='canvasHum' height="60"> {{ chart }}></canvas>
                </div>
                <div class="graph-containers"
                    style="background-color: #fff; box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);  background-color: #fff; float: right; width: 49%;">
                    <br>
                    <h3 style="margin-left: 2%;"> <img class="img-responsive" src="images/pressure.png" alt="" width="35px" style="margin-bottom: 7px; margin-right: 5px;"/> Pressão - </h3>
                    <div class="dadosRecentesPressao">
                      <p class="ValueSize" id="Press_actual"> %</p>
                    </div>
                    <canvas id='canvasPress' height="62"> {{ chart }}></canvas>
                </div>
            </div>
        </div>
        
        <div class="row dashboard-rows">
            
            <div class="col-md-9 pr-md-1">
                <div class="graph-containers" style="float: left; width: 49%;">
                    <br>
                    <h3 style="margin-left: 2%;"> <img class="img-responsive" src="images/co2.png" alt="" width="35px" style="margin-bottom: 5px; margin-right: 10px;"/>Teor CO2 - </h3>
                    <div class="dadosRecentesTC02">
                      <p class="ValueSize" id="QA_actual"> %</p>
                    </div>
                    <canvas id='canvasQA' height="62"> {{ chart }}></canvas>
                </div>
                <div class="graph-containers" style="float: right; width: 49%;">
                    <br>
                    <h3 style="margin-left: 2%;"> <img class="img-responsive" src="images/tvoc.png" alt="" width="35px" style="margin-bottom: 5px; margin-right: 0px;"/> Teor TVOC - </h3>
                    <div class="dadosRecentesTVOC">
                      <p class="ValueSize" id="TVOC_actual"> %</p>
                    </div>
                    <canvas id='canvasTVOC' height="62"> {{ chart }}></canvas>
                </div>
            </div>
        </div>
      
      </div>
    </div>
  </div>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.2.0/socket.io.js"></script>
    </body>
    </html>