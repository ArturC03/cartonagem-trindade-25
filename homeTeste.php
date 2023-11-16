<?php
include('nav.php');
?>
<meta charset="utf-8">
<!--<img hidden id="planta" src='images/planta_FABRIL.png' style="	margin-left: auto; margin-right: auto; display: block;"/>
-->
<script src='js/heatmap.min.js'></script>
<script src="js/jquery.min.js"></script>
<script src="js/socket.io.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/Chart.min.js"></script>
<script>
  window.onload = function() {
    var c = document.getElementById("canvasHeat");
    var ctx = c.getContext("2d");
    var img = document.getElementById("planta");
    ctx.drawImage(img, 10, 10);
  }
</script> 
<body>
  <br>
  
  <br>
  
  <div class="container-fluid page-container" >
  <br>
    
    <div style=" float: left; width:15%; height:900px; background-color:black; margin-top: -40px; margin-bottom: 70px; margin-left:-15px; ">
    <img  id="logo" src='images/trindade.png' style=" width: 100%;margin-top: 70%; " />
    </div>
    <div class="heatmap" style=" overflow-x: auto;
    white-space: nowrap;" >
    <div  style=" display: table;  margin: 0 auto;">
    <h1 align="center" style="border-bottom: 5px solid #a06845;">ACTUAL TEMPERATURE</h1>
    </div><br>
      <div id='heatMap'  style=" width:1280px;; min-height: 742px; max-height: auto;  padding: 3px;  margin: 0 auto; display: block; margin-left:15%; ">
        <img hidden id="planta" src='images/planta.png' max-width="100%" height="auto" />
        <canvas id="canvasHeat" width="1290" height="742" style="position:absolute; left: 0; top: 0">
        </canvas>
      </div>
      <div class="tooltip" ></div>
    </div>
  </div>
</body>
<script> 



///criacao do heatmap
var heatmapInstance = h337.create({
  container: document.getElementById('heatMap')
});


var testData = {
  min: 0,
  max: 35,
  
  
  data: [
        {x: 780, y: 400, value: 5,  radius:80}, //sensor 1
        {x: 910, y: 350, value: 10,  radius:80}, //sensor 2
        {x: 1050, y: 270, value: 11,  radius:80}, //sensor 3
        {x: 940, y: 270, value: 10,  radius:80}, //sensor 4
        {x: 840, y: 300, value: 12,  radius:80}, //sensor 5
        {x: 710, y: 320, value: 15,  radius:80}, //sensor 6
        {x: 480, y: 310, value: 22,  radius:100}, //sensor 7
        {x: 290, y: 300, value: 30,  radius:100}, //sensor 8
        {x: 610, y: 390, value: 20,  radius:100} //sensor 9   
        ]
      };
      heatmapInstance.setData(testData);  

      
///////////////////////////////
/* tooltip code start */


var demoWrapper = document.querySelector('.heatmap');
      var tooltip = document.querySelector('.tooltip');

      function updateTooltip(x, y, value) {
        // + 15 for distance to cursor
        var transform = 'translate(' + (x + 15) + 'px, ' + (y + 15) + 'px)';
        tooltip.style.MozTransform = transform; /* Firefox */
        tooltip.style.msTransform = transform; /* IE (9+) - note ms is lowercase */
        tooltip.style.OTransform = transform; /* Opera */
        tooltip.style.WebkitTransform = transform; /* Safari and Chrome */
        tooltip.style.transform = transform; /* One day, my pretty */ 
        tooltip.innerHTML = value;
      }

      demoWrapper.onmousemove = function(ev) {
        var x = ev.layerX;
        var y = ev.layerY;
        var value = heatmapInstance.getValueAt({
          x: x, 
          y: y
        });

        tooltip.style.display = 'block';

        updateTooltip(x, y, value);
      };
      demoWrapper.onmouseout = function() {
        tooltip.style.display = 'none';
      };


////////////////////////////SOCKETS
var socket = io.connect('http://localhost:8080');
socket.emit('dbRequestTemp');

  //PEDIDO update
  socket.on('dbUpdated', function(status){
    console.log("A base de dados foi atualizada!!!!!!");
    
    socket.emit('dbRequestTemp');
  });



  socket.on('dbTemp', function(db){
    console.log('Dados recebidos!', db);

    testData.data = [];

    db.forEach(sensor => {
      testData.data.push({x: sensor.location_x, y: sensor.location_y, value: sensor.temperature,  radius: 80});
    });

    heatmapInstance.setData(testData);
        //UpdateGraph();
      });
//////////////////////////////

</script>
<?php
include('footer.php');
?>