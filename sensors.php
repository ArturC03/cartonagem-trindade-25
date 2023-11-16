<!DOCTYPE html>
<meta charset="utf-8">
<html >
<link rel="stylesheet" type="text/css" href="css/sensors.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/Chart.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<?php
include('nav.php');
?>

<style type="text/css">
  .buttonSensor.selected{
    background-color: white;
    color:#555555;
    border:  2px solid #555555;
}
</style>

<body>
 
  <div class="container-fluid page-container" style="margin-top: 9px; height:100%">
    <div class="row dashboard-container" >
      <div class="col-md-2 column-buttons" id="column-buttons" style="overflow: auto;">
        <h3> Nós:</h3>
        
        <br>
        <?php  
        require 'php/connect.php';
        
        //error_reporting(0); 
        $mysqli = new mysqli("$servername", "$username", "$password", "$dbname");
        
        if ($mysqli->connect_errno) {
          echo "<p>MySQL error no {$mysqli->connect_errno} : {$mysqli->connect_error}</p>";
          exit();
        }

        $sql = "SELECT distinct id_sensor FROM `location` where status = 1 order by id_sensor;";  
        
        $result = $mysqli->query($sql);
        //$sensorId = sensorId;
        while($row = mysqli_fetch_array($result))  
        {  
          
          echo ' 
<button class="btn btn-md btn-secondary btn-block buttonSensor" onClick="SeeSensor(this.id)" id='. $row["id_sensor"].'  >Nó '. $row["id_sensor"].'
</button>'; 

        }
        ?>
        <br>
      </div>
      <div class="col-10">
        <div class="row dashboard-rows">
            <div class="col-md-3 pr-md-1">
                <div class="graph-containers">
                    <div style="height: 11%"></div>
                    <div class="variables-name">
                        <img class="img-responsive" src="images/temperature.png" alt="" />
                        <h3>&ensp;Temperatura</h3>
                    </div>
                    <div style="height: 25%"><br></div>
                    <div style="height: 25%; text-align: center; position:absolute; width:100%;">
                        <h1 class="ValueSize" id="Temp_actual">°C</h1>
                    </div>
                    <div style="height: 25%"><br></div>
                </div>
            </div>
            <div class="col-md-9 pr-md-1">
                <div class="graph-containers">
                    <br>
                    <h3 style="margin-left: 5%;">Temperatura</h3>

                    <canvas id='canvasTemp' height="62"> {{ chart }}</canvas>
                </div>
            </div>
        </div>
        <div class="row dashboard-rows">
            <div class="col-md-3 pr-md-1">
                <div class="graph-containers">
                    <div style="height: 11%"></div>
                    <div class="variables-name">
                        <img class="img-responsive" src="images/humidity.png" alt="" />
                        <h3>&ensp;Humidade</h3>
                    </div>
                    <div style="height: 25%"><br></div>
                    <div style="height: 25%; text-align: center; position:absolute; width:100%;">
                        <h1 class="ValueSize" id="Hum_actual">%</h1>
                    </div>
                    <div style="height: 25%"><br></div>
                </div>
            </div>
            <div class="col-md-9 pr-md-1">
                <div class="graph-containers">
                    <br>
                    <h3 style="margin-left: 5%;">Humidade</h3>
                    <canvas id='canvasHum' height="62"> {{ chart }}></canvas>
                </div>
            </div>
        </div>
        <div class="row dashboard-rows">
            <div class="col-md-3 pr-md-1">
                <div class="graph-containers">
                    <div style="height: 11%"></div>
                    <div class="variables-name">
                        <img class="img-responsive" src="images/pressure.png" alt="" />
                        <h3>&ensp;Pressão</h3>
                    </div>
                    <div style="height: 25%"><br></div>
                    <div style="height: 25%; text-align: center; position:absolute; width:100%;">
                        <h1 class="ValueSize" id="Press_actual">hPa</h1>
                    </div>
                    <div style="height: 25%"><br></div>
                </div>
            </div>
            <div class="col-md-9 pr-md-1">
                <div class=""
                    style="background-color: #fff; box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);  background-color: #fff;">
                    <br>
                    <h3 id="Press_actual" style="margin-left: 5%;">Pressão</h3>
                    <canvas id='canvasPress' height="62"> {{ chart }}></canvas>
                </div>
            </div>
        </div>
        <div class="row dashboard-rows">
            <div class="col-md-3 pr-md-1">
                <div class="graph-containers">
                    <div style="height: 11%"></div>
                    <div class="variables-name">
                        <img class="img-responsive" src="images/co2.png" alt="" />
                        <h3>&ensp;Teor CO2</h3>
                    </div>
                    <div style="height: 25%"><br></div>
                    <div style="height: 25%; text-align: center; position:absolute; width:100%;">
                        <h1 class="ValueSize" id="QA_actual">PPM</h1>
                    </div>
                    <div style="height: 25%"><br></div>
                </div>
            </div>
            <div class="col-md-9 pr-md-1">
                <div class="graph-containers">
                    <br>
                    <h3 style="margin-left: 5%;">Teor CO2</h3>
                    <canvas id='canvasQA' height="62"> {{ chart }}></canvas>
                </div>
            </div>
        </div>
        <div class="row dashboard-rows">
            <div class="col-md-3 pr-md-1">
                <div class="graph-containers">
                    <div style="height: 11%"></div>
                    <div class="variables-name">
                        <img class="img-responsive" src="images/tvoc.png" alt="" />
                        <h3>&ensp;Teor TVOC</h3>
                    </div>
                    <div style="height: 25%"><br></div>
                    <div style="height: 25%; text-align: center; position:absolute; width:100%;">
                        <h1 class="ValueSize" id="TVOC_actual">PPB</h1>
                    </div>
                    <div style="height: 25%"><br></div>
                </div>
            </div>
            <div class="col-md-9 pr-md-1">
                <div class="graph-containers">
                    <br>
                    <h3 style="margin-left: 5%;">Teor TVOC</h3>
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

    


    <script>

      document.addEventListener("DOMContentLoaded", function(event) { 
        document.getElementById("0101").click();
     });
            
        $('.buttonSensor').on('click', function(){
            $('.buttonSensor').removeClass('selected');
            $(this).addClass('selected');
        });



      var socket = io.connect('http://localhost:8080');
      var dataTemperatura = [];
      var sensorId = '0129';
      //pedido
      socket.on('dbUpdated', function(status){
        console.log("A base de dados foi atualizada!!!!!!");
        
        socket.emit('dbRequest', sensorId);
      });
      //rececao dos dados
      socket.on('dbNewData', function(db){
        console.log('Dados recebidos!');

        dataTemperatura = db.map(sensor => sensor.temperature);
        dataHumidity = db.map(sensor => sensor.humidity);
        dataPressure = db.map(sensor => sensor.pressure);
        dataQA = db.map(sensor => sensor.eCO2);
        dataHour = db.map(sensor => sensor.hour);
        dataTVOC = db.map(sensor => sensor.eTVOC);
        dataMinT = db.map(sensor => sensor.MinT);
        dataMaxT = db.map(sensor => sensor.MaxT);
        dataMinH = db.map(sensor => sensor.MinH);
        dataMaxH = db.map(sensor => sensor.MaxH);
        dataMinP = db.map(sensor => sensor.MinP);
        dataMaxP = db.map(sensor => sensor.MaxP);
        dataMinC = db.map(sensor => sensor.MinC);
        dataMaxC = db.map(sensor => sensor.MaxC);
        dataMinV = db.map(sensor => sensor.MinV);
        dataMaxV = db.map(sensor => sensor.MaxV);
        dataHour = dataHour.reverse();
        
        UpdateGraph();
      });

      function UpdateGraph(){

    //temperature chart
    var ctx = document.getElementById('canvasTemp').getContext('2d');
    
    var myTempChart;
    if (myTempChart) myTempChart.destroy();
    myTempChart = new Chart(ctx, {
      type: 'line',
      data: {
          labels: dataHour, //hours,
          datasets: [
          {
              data: dataTemperatura , //temp,
              backgroundColor: '#D55858',
              hoverBackgroundColor:"#ffff",
              pointBackgroundColor: "#D55858",
              pointBorderColor: '#fff',
              borderColor: '#D55858',
              hoverBorderColor:"#D55858",
              fill: false
            },            
            ]
          },
          options: {
            legend:{
              display: false
            },
            scales: {
              xAxes: [{
                display:true
              }],
              yAxes: [{
                display: true,
                ticks: {
                  min: Math.min.apply(this, dataMinT) - 10,
                  max: Math.max.apply(this, dataMaxT) + 10
                }
              }]
            }
          }
        });

      

      //Humidity chart
      var ctx2 = document.getElementById('canvasHum').getContext('2d');
      var myHumChart;
      if (myHumChart) myHumChart.destroy();
      myHumChart = new Chart(ctx2, {
        type: 'line',
        data: {
          labels: dataHour, //hours,
          datasets: [
          {
              data: dataHumidity,//hum,
              backgroundColor: '#3F87CE',
              hoverBackgroundColor:"#ffff",
              pointBackgroundColor: "#3F87CE",
              pointBorderColor: '#fff',
              borderColor: '#3F87CE',
              hoverBorderColor:"#3F87CE",
              fill: false
            },            
            ]
          },
          options: {
            legend:{
              display: false
            },
            scales: {
              xAxes: [{
                display:true
              }],
              yAxes: [{
                display: true,
                ticks: {
                  min: Math.min.apply(this, dataMinH) - 10,
                  max: Math.max.apply(this, dataMaxH) + 10
                }
              }]
            }
          }
        });

      
      //Pressure chart
      var ctx3 = document.getElementById('canvasPress').getContext('2d');
      var myPressChart;
      if (myPressChart) myPressChart.destroy();
      myPressChart = new Chart(ctx3, {
        type: 'line',
        data: {
            labels: dataHour, //hours,
            datasets: [
            {
              data: dataPressure,//press,
              backgroundColor: '#40B97C',
              hoverBackgroundColor:"#ffff",
              pointBackgroundColor: "#40B97C",
              pointBorderColor: '#fff',
              borderColor: '#40B97C',
              hoverBorderColor:"#40B97C",
              fill: false
            },            
            ]
          },
          options: {
            legend:{
              display: false
            },
            scales: {
              xAxes: [{
                display:true
              }],
              yAxes: [{
                display: true,
                ticks: {
                  min: Math.min.apply(this, dataMinP) - 10,
                  max: Math.max.apply(this, dataMaxP) + 10
                }
              }]
            }
          }
        });

      //Qualidade do AR chart
      var ctx4 = document.getElementById('canvasQA').getContext('2d');
      var myQAChart;
      if (myQAChart) myQAChart.destroy();
      myQAChart = new Chart(ctx4, {
        type: 'line',
        data: {
          labels: dataHour, //hours,
          datasets: [
          {
              data: dataQA,//QA,
              backgroundColor: '#ffc61a',
              hoverBackgroundColor:"#ffff",
              pointBackgroundColor: "#ffc61a",
              pointBorderColor: '#fff',
              borderColor: '#ffc61a',
              hoverBorderColor:"#ffc61a",
              fill: false
            },            
            ]
          },
          options: {
            legend:{
              display: false
            },
            scales: {
              xAxes: [{
                display:true
              }],
              yAxes: [{
                display: true,
                ticks: {
                  min: Math.min.apply(this, dataMinC) - 10,
                  max: Math.max.apply(this, dataMaxC) + 10
                }
              }]
            }
          }
        });


        //TVOC chart
      var ctx5 = document.getElementById('canvasTVOC').getContext('2d');
      var myVOCChart;
      if (myVOCChart) myVOCChart.destroy();
      myVOCChart = new Chart(ctx5, {
        type: 'line',
        data: {
          labels: dataHour, //hours,
          datasets: [
          {
              data: dataTVOC,//TVOC,
              backgroundColor: '#f28c23',
              hoverBackgroundColor:"#ffff",
              pointBackgroundColor: "#f28c23",
              pointBorderColor: '#fff',
              borderColor: '#f28c23',
              hoverBorderColor:"#f28c23",
              fill: false
            },            
            ]
          },
          options: {
            legend:{
              display: false
            },
            scales: {
              xAxes: [{
                display:true
              }],
              yAxes: [{
                display: true,
                ticks: {
                  min: Math.min.apply(this, dataMinV) - 10,
                  max: Math.max.apply(this, dataMaxV) + 10
                }
              }]
            }
          }
        });

      console.log("dataTemperatura", dataTemperatura);
      document.getElementById("Temp_actual").innerHTML = parseFloat(dataTemperatura[17]) + "°C";
      document.getElementById("Hum_actual").innerHTML = parseFloat(dataHumidity[17]) + "%";
      document.getElementById("Press_actual").innerHTML = parseFloat(dataPressure[17]) + "hPa";
      document.getElementById("QA_actual").innerHTML = parseFloat(dataQA[17]) + "PPM";
      document.getElementById("TVOC_actual").innerHTML = parseFloat(dataTVOC[17]) + "PPB";
    }
    window.onload = SeeSensor('0101');
    
    function SeeSensor(clicked_id){
      
      sensorId = clicked_id;

      socket.emit('dbRequest', sensorId);

    }
  </script>
   <?php
//include('footer.php');
?>
