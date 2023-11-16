<?php

  include('nav.php');
  include('monthdb.php');
include('connect.php');
  header("refresh: 10000;");  

?>
<style>

    .body {
  position: relative;
  width: 100%;
  height: 0;
  padding-bottom: 75%; /* Proporção 4:3 */
  background-image: url("plantaV2ssensores.png");
  background-size: cover;
  overflow: hidden;
}
body{
  overflow: hidden;

}
    .text1 {
      position: absolute;
      top: 30%; /* Ajuste conforme necessário */
      left: 38%; /* Ajuste conforme necessário */
      bottom:99%;
      transform: translate(-50%, -50%);
      font-size: 14px;
      
      @media (max-width: 768px) {
      font-size: 10px;
    }

    /* Tamanhos de fonte para telas ainda menores */
    @media (max-width: 480px) {
      font-size: 8px;
    }
  }
    .text2{
      position: absolute;
      top: 30%; /* Ajuste conforme necessário */
      left: 68%; /* Ajuste conforme necessário */
      bottom:99%;
      transform: translate(-50%, -50%);
      font-size: 14px;
      
      @media (max-width: 768px) {
        font-size: 10px;
      }
  
      /* Tamanhos de fonte para telas ainda menores */
      @media (max-width: 480px) {
        font-size: 8px;
      }
    }
    .text3{
      position: absolute;
      top: 48%; /* Ajuste conforme necessário */
      left: 40%; /* Ajuste conforme necessário */
      bottom:99%;
      transform: translate(-50%, -50%);
      font-size: 14px;
      
      @media (max-width: 768px) {
        font-size: 10px;
      }
  
      /* Tamanhos de fonte para telas ainda menores */
      @media (max-width: 480px) {
        font-size: 8px;
      }
    }
    .text4{
      position: absolute;
      top: 60%; /* Ajuste conforme necessário */
      left: 40%; /* Ajuste conforme necessário */
      bottom:99%;
      transform: translate(-50%, -50%);
      font-size: 14px;
      
      @media (max-width: 768px) {
        font-size: 10px;
      }
  
      /* Tamanhos de fonte para telas ainda menores */
      @media (max-width: 480px) {
        font-size: 8px;
      }
    }
    .text5{
      position: absolute;
      top: 72%; /* Ajuste conforme necessário */
      left: 40%; /* Ajuste conforme necessário */
      bottom:99%;
      transform: translate(-50%, -50%);
      font-size: 14px;
      
      @media (max-width: 768px) {
        font-size: 10px;
      }
  
      /* Tamanhos de fonte para telas ainda menores */
      @media (max-width: 480px) {
        font-size: 8px;
      }
    }
    .text6{
      position: absolute;
      top: 65%; /* Ajuste conforme necessário */
      left: 86%; /* Ajuste conforme necessário */
      bottom:99%;
      transform: translate(-50%, -50%);
      font-size: 12px;
      
      @media (max-width: 768px) {
        font-size: 6px;
      }
  
      /* Tamanhos de fonte para telas ainda menores */
      @media (max-width: 480px) {
        font-size: 4px;
      }
    }
    #fullscreen-img {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
    }
  </style>
  <?php
      require 'php/connect.php';
      //error_reporting(0); 
      $mysqli = new mysqli("$servername", "$username", "$password", "$dbname");

      if ($mysqli->connect_errno) {
        echo "<p>MySQL error no {$mysqli->connect_errno} : {$mysqli->connect_error}</p>";
        exit();
      }
      $sql="SELECT AVG(temperature) AS media_temp, AVG(humidity) AS hum_media , AVG(eCO2) AS medEco, AVG(eTVOC) AS medtvoc from sensors where id_sensor in ('0101','0102','0107','0108')";
      $result = mysqli_query($conn, $sql);
      $linha = mysqli_fetch_assoc($result);
      $media=$linha['media_temp'];
      $hum=$linha['hum_media'];
      $Eco=$linha['medEco'];
      $tvoc=$linha['medtvoc'];
      /** -------------------------------*/
      $sql2="SELECT AVG(temperature) AS media_temp2,AVG(humidity) AS hum_media2 , AVG(eCO2) AS medEco2, AVG(eTVOC) AS medtvoc2 from sensors where id_sensor in ('0104','0105','0106','010A','010B')";
      $result2 = mysqli_query($conn, $sql2);
      $linha2 = mysqli_fetch_assoc($result2);
      $media2=$linha2['media_temp2'];
      $hum2=$linha2['hum_media2'];
      $Eco2=$linha2['medEco2'];      
      $tvoc2=$linha['medtvoc2'];

      /** -------------------------------*/
      $sql3="SELECT AVG(temperature) AS media_temp3,AVG(humidity) AS hum_media3 , AVG(eCO2) AS medEco3, AVG(eTVOC) AS medtvoc3 from sensors where id_sensor in ('010C','010D','010E','010F','0110','0111','0112','0113','0114')";
      $result3 = mysqli_query($conn, $sql3);
      $linha3 = mysqli_fetch_assoc($result3);
      $media3=$linha3['media_temp3'];
      $hum3=$linha3['hum_media3'];
      $Eco3=$linha3['medEco3'];
      $tvoc3=$linha['medtvoc3'];

      /** -------------------------------*/
      $sql4="SELECT AVG(temperature) AS media_temp4,AVG(humidity) AS hum_media4 , AVG(eCO2) AS medEco4, AVG(eTVOC) AS medtvoc4 from sensors where id_sensor in ('0115','0116','0117','0118','0119','011A','011B','011C')";
      $result4 = mysqli_query($conn, $sql4);
      $linha4 = mysqli_fetch_assoc($result4);
      $media4=$linha4['media_temp4'];
      $hum4=$linha4['hum_media4'];
      $Eco4=$linha4['medEco4'];
      $tvoc4=$linha['medtvoc4'];

      /** -------------------------------*/
      $sql5="SELECT AVG(temperature) AS media_temp5,AVG(humidity) AS hum_media5 , AVG(eCO2) AS medEco5, AVG(eTVOC) AS medtvoc5 from sensors where id_sensor in ('011D','011E','011F','0120','0121','0122')";
      $result5 = mysqli_query($conn, $sql5);
      $linha5 = mysqli_fetch_assoc($result5);
      $media5=$linha5['media_temp5'];
      $hum5=$linha5['hum_media5'];
      $Eco5=$linha5['medEco5'];
      $tvoc5=$linha['medtvoc5'];

      /** -------------------------------*/
      $sql6="SELECT AVG(temperature) AS media_temp6,AVG(humidity) AS hum_media6, AVG(eCO2) AS medEco6, AVG(eTVOC) AS medtvoc6 from sensors where id_sensor in ('0123','0124','0125','0126','0127','0128')";
      $result6 = mysqli_query($conn, $sql6);
      $linha6 = mysqli_fetch_assoc($result6);
      $media6=$linha6['media_temp6'];
      $hum6=$linha6['hum_media6'];
      $Eco6=$linha6['medEco6'];
      $tvoc6=$linha['medtvoc6'];

      /** -------------------------------*/
    ?>  
    <body>
    <img id="fullscreen-img" src="images/plantaV2ssensores.png">   
     <div class="text-container">
      <p class="text1">Temperatura:<?php  echo number_format($media, 1, '.', '')?>ºC<br>Humidade:<?php  echo number_format($hum, 1, '.', '')?>%<br>eCO2:<?php  echo number_format($Eco, 1, '.', '')?>PPM<br>eTVOC:<?php  echo number_format($tvoc, 1, '.', '')?></p>
      <p class="text2">Temperatura:<?php  echo number_format($media2, 1, '.', '')?>ºC<br>Humidade:<?php  echo number_format($hum2, 1, '.', '')?>%<br>eCO2:<?php  echo number_format($Eco2, 1, '.', '')?>PPM<br>eTVOC:<?php  echo number_format($tvoc2, 1, '.', '')?></p>
      <p class="text3">Temperatura:<?php  echo number_format($media3, 1, '.', '')?>ºC<br>Humidade:<?php  echo number_format($hum3, 1, '.', '')?>%<br>eCO2:<?php  echo number_format($Eco3, 1, '.', '')?>PPM<br>eTVOC:<?php  echo number_format($tvoc3, 1, '.', '')?></p>
      <p class="text4">Temperatura:<?php  echo number_format($media4, 1, '.', '')?>ºC<br>Humidade:<?php  echo number_format($hum4, 1, '.', '')?>%<br>eCO2:<?php  echo number_format($Eco4, 1, '.', '')?>PPM<br>eTVOC:<?php  echo number_format($tvoc4, 1, '.', '')?></p>
      <p class="text5">Temperatura:<?php  echo number_format($media5, 1, '.', '')?>ºC<br>Humidade:<?php  echo number_format($hum5, 1, '.', '')?>%<br>eCO2:<?php  echo number_format($Eco5, 1, '.', '')?>PPM<br>eTVOC:<?php  echo number_format($tvoc5, 1, '.', '')?></p>
      <p class="text6">Temperatura:<?php  echo number_format($media6, 1, '.', '')?>ºC<br>Humidade:<?php  echo number_format($hum6, 1, '.', '')?>%<br>eCO2:<?php  echo number_format($Eco6, 1, '.', '')?>PPM<br>eTVOC:<?php  echo number_format($tvoc6, 1, '.', '')?></p>
    </div>
    
    </body>
<script>
    setInterval(function(){
        location.reload();
    }, 600000); // 10 minutos em milissegundos
</script>
<script>
    // Bloqueia o cursor dentro da área visível da página
    function lockCursor() {
      document.addEventListener('mousemove', handleMouseMove);
    }


  </script>
  <script>
    function toggleFullscreen() {
      const img = document.getElementById("fullscreen-img");

      if (img.requestFullscreen) {
        img.requestFullscreen();
      } else if (img.mozRequestFullScreen) { // Firefox
        img.mozRequestFullScreen();
      } else if (img.webkitRequestFullscreen) { // Chrome, Safari and Opera
        img.webkitRequestFullscreen();
      } else if (img.msRequestFullscreen) { // IE/Edge
        img.msRequestFullscreen();
      }
    }
  </script>
</head>
