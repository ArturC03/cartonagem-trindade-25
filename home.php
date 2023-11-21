<!DOCTYPE html>
<!--Admin123. -->
<meta charset="utf-8">
<html>
  <head>
  <script src="https://unpkg.com/heatmap.js/build/heatmap.min.js"></script>

  <style>
    .rotate {
  /* FF3.5+ */
  -moz-transform: rotate(-90.0deg);
  /* Opera 10.5 */
  -o-transform: rotate(-90.0deg);
  /* Saf3.1+, Chrome */
  -webkit-transform: rotate(-90.0deg);
  /* IE6,IE7 */
  filter: progid: DXImageTransform.Microsoft.BasicImage(rotation=0.083);
  /* IE8 */
  -ms-filter: "progid:DXImageTransform.Microsoft.BasicImage(rotation=0.083)";
  /* Standard */
  transform: rotate(-90.0deg);
}
#fullscreen-img {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
    }

  .heatmap {
    position: relative; /* Altera para posição relativa para manter as coordenadas relativas */
  }


    </style>
  </head>
<link rel="stylesheet" type="text/css" href="css/sensors.css">
<link rel="stylesheet" href="css/bootstrap.min.css">

<script src="js/jquery.min.js"></script>
<script src="js/socket.io.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src='js/heatmap.min.js'></script>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- link to gradient -->
 <script src='http://cdn.zingchart.com/zingchart.min.js'></script>
 <script src="https://cdn.zingchart.com/zingchart.min.js"></script>

<script type="text/javascript" src="js/Chart.min.js"></script>
<script>
  window.onload = function() {
    var c = document.getElementById("canvasHeat");
    var ctx = c.getContext("2d");
    var img = document.getElementById("planta");
    ctx.drawImage(img, 10, 10);
  } 
</script> 

<style>
  .buttonSensor.selected{
    background-color: white;
    color:#555555;
}
.typeButton.selected{
    background-color: white;
    color:#555555;
    border:  2px solid #555555;
}
body{
  width: 100%;
}

footer {
    position: absolute;
    bottom: 0;
    color: black;
    width: 100%;
    height: 40px;    
    text-align: right;
    line-height: 50px;
    top: 635px;
    left:-10px;
}


</style>

<body class="container-fluid" style="padding: 0;">

<?php

  include('nav.inc.php');
  include('monthdb.php');

  header("refresh: 10000;");  

?>

  <div class="container-fluid page-container" style="margin-left: 0px; margin-right: 0px; width: auto;">
    <div class="row dashboard-container" >

      <div class="col-12" style="margin-top: 7px;">
        <div class="row dashboard-rows"> 
          <div class="col">
            <div class="graph-containers" style="display:flex">
              <div class="Wrapper" style="width: 100%; margin-top: 0px;">
                <div id='heatMap1' style="width: 100%; padding: 0px;  margin: 0 auto; display: block;">
                <img  id="planta" src='images/plantaV3.png' style=" width:100vh;height: auto;" />
                <canvas id="canvasHeat" width="100vh" height="auto" style="position:absolute; left: 0; top: 0">
                </canvas> 
              </div>
              <div class="tooltip" style="position: absolute; left: 0; top: 0; background: rgba(0,0,0,.8); color: white;
              font-size: 14px; padding: 5px; display: block; line-height: 18px; display:none;"></div>
            </div>


            <div width="15%" height="100%">
             <div id='GradTemperature' style="width: 150px; height: 600px; margin-top: 10%; margin-bottom: -10%">
            </div>

          </div>
        </div>
      </div>
    </div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.2.0/socket.io.js"></script>
</body>
<footer>
<b>Versão:1.0(28/07/2023)</b>
</footer>

<script> 
 

 var heatmapInstance = h337.create({
  container: document.getElementById('heatMap1')

});
$.ajax({
  url: 'getsensordata.php',
  dataType: 'json',
  Type:'GET',
  success: function(data1) {
    // Define um valor fixo de 30 para o campo "radius" de todos os sensores
    for (var i = 0; i < data1.data.length; i++) {
      heatmapInstance.addData({
        x:data1.data[i].x,
        y:data1.data[i].y,
        value:data1.data[i].value,
        radius:30
      })
    }
    console.log(data1);
  },
  error: function() {
    alert('Erro ao carregar dados dos sensores.');
  }
});


  document.addEventListener("DOMContentLoaded", function(event) { 
    document.getElementById("0101").click();
  });

  $('.buttonSensor').on('click', function(){
    $('.buttonSensor').removeClass('selected');
    $(this).addClass('selected');
  });

  document.addEventListener("DOMContentLoaded", function(event) { 
    document.getElementById("temperature").click();
  });

  $('.typeButton').on('click', function(){
    $('.typeButton').removeClass('selected');
    $(this).addClass('selected');
  });


  var dataTemperatura = [];
  var dataHumidity =  [];
  var dataPressure = [];
  var dataCO2 = [];
  var dataQA = [];
  var dataHour = [];

   var socket = io.connect('http://localhost:8080');

      socket.emit('dbRequestTemp');
      
      var sensorId = '01';

      //pedido update
      socket.on('dbUpdated', function(status){
        console.log("A base de dados foi atualizada!!!!!!");

        socket.emit('dbRequestMeasure', sensorId);
        socket.emit('dbRequestTemp');
      });
      //rececao dos dados do gráfico
      socket.on('dbNew', function(db){
      console.log('Dados recebidos!');

        dataTemperatura = db.map(sensor => sensor.temperature);
        dataHumidity = db.map(sensor => sensor.humidity);
        dataPressure = db.map(sensor => sensor.pressure);
        dataSensor = db.map(sensor => sensor.id_sensor);
        dataHour = db.map(sensor => sensor.hour);
        dataQA = db.map(sensor => sensor.eCO2);
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
        dataTemperatura = dataTemperatura.reverse();
        dataHumidity = dataHumidity.reverse();
        dataPressure = dataPressure.reverse();
        dataQA = dataQA.reverse();
        dataTVOC = dataTVOC.reverse();
        dataMinT= dataMinT.reverse();
        dataMaxT = dataMaxT.reverse();
        dataMinH = dataMinH.reverse();
        dataMaxH = dataMaxH.reverse();
        dataMinP = dataMinP.reverse();
        dataMaxP = dataMaxP.reverse();
        dataMinC = dataMinC.reverse();
        dataMaxC = dataMaxC.reverse();
        dataMinV = dataMinV.reverse();
        dataMaxV = dataMaxV.reverse();
        
      //HOVER EVENT ON GRAPHIC
      dataSensor.forEach(function(item, index) {
      // buttonNumber = dataSensor.indexOf(dataSensor[i]);
      $('#' + item).hover(function() {
        hoverEvent(index);
        console.log('skjdfahbedfv', index);
      });
    });
    //END OF HOVER EVENT

        UpdateGraph(SensorMeasure);
      });

      //rececao de dados heatmap
    

    //heatmapInstance.setData(testData);
        //UpdateGraph();
  

    function SeeMeasure(measure){

      SensorMeasure = measure;


     UpdateGraph(SensorMeasure);


    }
    function UpdateGraph(SensorMeasure){
   
   
   var ValorMinimo = 0;
   var ValorMaximo = 0;

  if(SensorMeasure=="temperature"){
       DataMeasure = dataTemperatura;
       DataMin = dataMinT;
       DataMax = dataMaxT;
       ValorMinimo = Math.min.apply(this, DataMin) - 10;
       stepSize: 0.5;
       ValorMaximo = Math.max.apply(this, DataMax) + 10;
     } else if (SensorMeasure=="humidity"){
       DataMeasure = dataHumidity;
       DataMin = dataMinH;
       DataMax = dataMaxH;
       ValorMinimo = Math.min.apply(this, DataMin) - 10;
       stepSize: 0.5;
       ValorMaximo = Math.max.apply(this, DataMax) + 10;
     } else if (SensorMeasure=="pressure"){
       DataMeasure = dataPressure;
       DataMin = dataMinP;
       DataMax = dataMaxP;
       ValorMinimo = Math.min.apply(this, DataMin) - 10;
       stepSize: 0.5;
       ValorMaximo = Math.max.apply(this, DataMax) + 10;
     } else if (SensorMeasure=="co2"){
       DataMeasure=dataQA;
       DataMin = dataMinC;
       DataMax = dataMaxC;
       ValorMinimo = Math.min.apply(this, DataMin) - 10;
       stepSize: 0.5;
       ValorMaximo = Math.max.apply(this, DataMax) + 10;
     } else if (SensorMeasure=="tvoc"){
       DataMeasure=dataTVOC;
       DataMin = dataMinV;
       DataMax = dataMaxV;
       ValorMinimo = Math.min.apply(this, DataMin) - 10;
       stepSize: 0.5;
       ValorMaximo = Math.max.apply(this, DataMax) + 10;
     }
     

// chart


   
   var ctx2 = document.getElementById('ChartLine').getContext('2d');
   var myChart;
   if (typeof myChart !== "undefined") {
     myChart.destroy();
   }
   if (myChart) myChart.destroy();
   myChart = new Chart(ctx2, {
     type: 'line',
     data: {
       labels: dataHour,
       datasets: [
       {
           data: DataMeasure,
           backgroundColor: '#3F87CE',
           hoverBackgroundColor:"#ffff",
           pointBackgroundColor: "#3F87CE",
           pointBorderColor: '#fff',
           borderColor: '#3F87CE',
           hoverBorderColor:"#3F87CE",
           fill: false
         }        
         ]
       },
       options: {
         maintainAspectRatio: false,
         responsive: true,
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
               min: ValorMinimo,
               max: ValorMaximo
             }
           }]
         }
       }
     });

   

    console.log("dataTemperatura", dataTemperatura);
 }

   /////// SOCKETS
   window.onload = SeeSensor('0101');
   //window.onload = UpdateGraph();
    
    function SeeSensor(clicked_id){

      sensorId = clicked_id;


      socket.emit('dbRequestMeasure', sensorId);

    };    
      
///////////////////////////////

var demoWrapper = document.querySelector('.Wrapper');
var tooltip = document.querySelector('.tooltip');
function updateTooltip(x, y, value) {
  // + 15 for distance to cursor
  var transl = 'translate(' + (x + 15) + 'px, ' + (y + 15) + 'px)';
  tooltip.style.webkitTransform = transl;
  tooltip.innerHTML = value;
};
demoWrapper.onmousemove = function(ev) {
  var x = ev.layerX;
  var y = ev.layerY;
  // getValueAt gives us the value for a point p(x/y)
  var value = heatmapInstance.getValueAt({
    x: x, 
    y: y
  });
  

  actualTemperature = value;
  //TempSensor = text;

  renderTemperatures();

  tooltip.style.display = 'block';
  updateTooltip(x, y, value);
};
// hide tooltip on mouseout
demoWrapper.onmouseover = function() {
  tooltip.style.display = 'none';
};

/* tooltip code end */





////////////////LEGEND
    var actualTemperature = 0;

     var GradTemperature;

renderTemperatures();

function renderTemperatures() {
  var GradTemperature = {
                  "graphset": [
        {
            "type": "mixed",
            "background-color":"none",
            "scale-x":{
                "visible":0
            },
            "scale-y":{
                "guide":{
                    "visible":0
                },
                "tick":{
                    "line-color":"#A8A8A8",
                    "line-width":1
                },
                "line-width":1,
                "line-color":"#A8A8A8",
                "values":"0:35:1",
                "format":"%v°C",
                "markers":[
                    {
                        "type":"line",
                        "range":5
                    }    
                ]
            },
            "tooltip":{
                "visible":0
            },
            
            "plot":{
                "bars-overlap":"100%",
                "hover-state":{
                    "visible":0
                }
            },

            // labels:[
            //   {
            //     text:"Sensor 1",
            //     x:"15%", 
            //     y:"1%",
            //     fontSize:"22px",
            //     borderWidth:"1px",
            //     padding : "5px",
            //     borderRadius : 10
            //   }
            // ],
            "series": [
                {
                    "type":"bar",
                    "values": [35],
                    "gradient-colors":"#e6e6ff #d4d4ff #b3c0f3 #99cdcc #80ea96 #80ff66 #a5ff4d #ddff33 #ffb91a #ff0300",
                    "gradient-stops":"0.1 0.2 0.3 0.4 0.5 0.6 0.7 0.8 0.9 1",
                    "fill-angle":-90
                },
                {
                  "type":"scatter",
                  "values":[actualTemperature],
                  "marker":{
                    "type":"rectangle",
                    "height":3,
                    "width":"20%"
                  }
                  },
                  
               
            ]
        }
    ]
};

  zingchart.render({ 
      id : 'GradTemperature', 
      data : GradTemperature, 
      height: 600, 
      width: 140
  });
}







//////////////////////////////

</script>

</html>