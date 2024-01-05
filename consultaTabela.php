<?php
include('config.inc.php');

if (isset($_SESSION['username'])) {
    include('header.inc.php');

    $ids = array();
    if(isset($_POST["ids"])){
        $idsSelecionados = $_POST["ids"];
        
        foreach($idsSelecionados as $id){
            array_push($ids, $id);
        }
    }
    
    if(isset($_POST['submit'])){
        $sensores= "";
        foreach($ids as $id){
            $sensores= $sensores. "('".$id."',";
        }
        $sensores= substr($sensores, 0, -1);
        $sensores= $sensores.")";

        $dataMinima= "".$_POST["mindate"];
        $dataMaxima= "".$_POST["maxdate"];
        
        $horaMinima= $_POST["mintime"];
        $horaMaxima= $_POST["maxtime"];
        
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
    }
    ?>
    <!-- <p id="mindate" class="d-none"><?php echo $dataMinima; ?></p>
    <p id="maxdate" class="d-none"><?php echo $dataMaxima; ?></p>
    <p id="mintime" class="d-none"><?php echo $horaMinima; ?></p>
    <p id="maxtime" class="d-none"><?php echo $horaMaxima; ?></p>
    <p id="sensores" class="d-none"><?php print_r($sensores); ?></p>
    <script src="js/pageScroll.js"></script> -->
    <main class="table">
        <section class="table_header"> 
            <h1 class="title">Consulta</h1>    
            <div class="input-group">
                <input type="search" placeholder="Procurar dados...">
                <img src="images/search.svg" alt="">
            </div>
            <div class="radio-inputs">
                <label class="radio">
                    <input type="radio" name="column" value="0" checked>
                    <span class="name">ID</span>
                </label>
                <label class="radio">
                    <input type="radio" name="column" value="1">
                    <span class="name">Hora</span>
                </label>
                <label class="radio">
                    <input type="radio" name="column" value="2">
                    <span class="name">Data</span>
                </label>
                <label class="radio">
                    <input type="radio" name="column" value="3">
                    <span class="name">Temperatura (ºC)</span>
                </label>
                <label class="radio">
                    <input type="radio" name="column" value="4">
                    <span class="name">Humidade (%)</span>
                </label>
                <label class="radio">
                    <input type="radio" name="column" value="5">
                    <span class="name">Pressão (HPA)</span>
                </label>
                <label class="radio">
                    <input type="radio" name="column" value="6">
                    <span class="name">CO2 (PPM)</span>
                </label>
                <label class="radio">
                    <input type="radio" name="column" value="7">
                    <span class="name">TVOC (PPB)</span>
                </label>
            </div>
        </section>
        <section class="table_body">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Hora</th>
                        <th>Data</th>
                        <th>Temperatura (ºC)</th>
                        <th>Humidade (%)</th>
                        <th>Pressão (HPA)</th>
                        <th>CO2 (PPM)</th>
                        <th>TVOC (PPB)</th>
                    </tr>
                </thead>
                <tbody>
                     <?php
                        $mesMaxPesquisa = $mesMaxPesquisa +1;

                        while($mesMinPesquisa <> $mesMaxPesquisa) {
                            $dataMensal = "20".$anoMinPesquisa."-".$mesMinPesquisa."-01";
                            $dataMensal = strtotime($dataMensal);
                            
                            $dbname2 = $anoMinPesquisa."_".date('M', $dataMensal);
                            
                            if($mesMinPesquisa == 12){
                                $anoMinPesquisa++;
                                $mesMinPesquisa = 0;
                            }
                            
                            $result = my_query("SELECT distinct s.* FROM sensors s where ".$comp2.$datas."s.id_sensor in $sensores order by date ASC;");
                            
                            foreach($result as $row){ 
                                echo '  
                                <tr>  
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
                                $result = my_query("SELECT distinct s.* FROM sensors s where ".$comp2.$datas."s.id_sensor in $sensores order by date ASC;");
                                
                                while($row = mysqli_fetch_array($result))  
                                {   
                                    echo '  
                                    <tr>  
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

                        $result2 = my_query("SELECT id_sensor,hour,date,temperature,humidity,pressure,eCO2,eTVOC from sensors where id_sensor in $sensores order by date ASC");
                        $fileName = 'download/dados.csv';
                        
                        $file = fopen($fileName, 'w');
                        fputcsv($file, array('id_sensors', 'Hora', 'Data', 'Temperatura', 'Humidade','Pressão','CO2','TVOC'),';');
                        while ($row = mysqli_fetch_array($result2,MYSQLI_NUM)) {
                            $formattedTemperature = ltrim(sprintf("%.3f", $row[3]), '0');
                            $row[3] = $formattedTemperature;
                            $formattedHumidity = ltrim(sprintf("%.3f", $row[4]), '0');
                            $row[4] = $formattedHumidity;
                            
                            $formattedPressure = ltrim(sprintf("%.3f", $row[5]), '0');
                            $row[5] = $formattedPressure;
                            
                            fputcsv($file, $row,';');
                        }
                        @header('Content-Type: text/csv');
                        @header('Content-Disposition: attachment; filename="' . $fileName . '"');
                        fclose($file);
                    ?>
                </tbody>
            </table>
            <div class="loader">
                <div class="justify-content-center jimu-primary-loading"></div>
            </div>
        </section>
        
        <section class="button-container">
            <button class="learn-more" onclick="window.location.href='consultaGraficos.php';">
                <div class="circle">
                    <div class="icon arrow"></div>
                </div>
                <span class="button-text">Gráficos</span>
            </button>
            <a href="download/dados.csv" download>
                <button class="learn-more">
                    <div class="circle">
                        <div class="icon arrow"></div>
                    </div>
                    <span class="button-text">Obter CSV</span>
                </button>
            </a>
            <button class="learn-more" onclick="window.location.href='archive.php';">
                <div class="circle">
                    <div class="icon arrow"></div>
                </div>
                <span class="button-text">Voltar</span>
            </button>
        </section>
    </main>
        
    <script src="js/consultaTabela.js"></script>
    <?php
    include('footer.inc.php');
    }else{
      header('Location: login.php');
    }