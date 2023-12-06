<?php
include('config.inc.php');

if (isset($_SESSION['username'])) {
    include('header.inc.php');

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

    $sensores= "('$id1', '$id2', '$id3')";
    $comp2= $_GET['bbbb'];
    $datas= $_GET['cccc'];
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

    $dataAtual= $anoAtual."_".$mesAtual;
    
    if($anoPesquisa == $anoAtual){
      $i= $mesAtual-$mesPesquisa;
    }

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

require 'connect.inc.php';
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

  $sql = "SELECT distinct s.* FROM $dbname2.sensors s where ".$comp2.$datas."s.id_sensor in $sensores order by date ASC;";

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
        

    <script>
    function altera2(){
      
      window.location.href = "consultaGraficos.php?sensor=<?php echo urlencode($sensores);?>";
      
    
    } 
    function back(){
      
      window.location.href = "archive2.php";
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
<?php
  include('footer.inc.php');
}else{
  header('Location: login.php');
}