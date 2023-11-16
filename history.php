<!DOCTYPE html>
<meta charset="utf-8">
<html >
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href=" https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

<?php
include('nav.php');
?>

<body>
  <div><br></div>
  <br>
  <br>
  <br>
  <div class="container"  style="max-width: 1700px;">


    <table  id="tableSensors" class="table table-striped table-bordered" style="width:100%">  
      <thead class="thead-dark">  
        <tr>  
          <th>Id do Nó</th>
          <th>Hora</th>
          <th>Data</th>
          <th>Temperatura</th>
          <th>Humidade</th>
          <th>Pressão</th>
          <th>Altitude</th>
          <th>CO2</th>
          <th>TVOC</th>
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

        $sql = "SELECT s.* FROM `sensors` s, `location` l where s.id_sensor = l.id_sensor and l.status = 1 order by sensor_id DESC LIMIT 100;";  
        $result = $mysqli->query($sql);
        while($row = mysqli_fetch_array($result))  
        { 
          
          echo '  
          <tr *ngFor="let sensor of sensorInfo.data |filter : term| paginate: { itemsPerPage: 6, currentPage: p }">  
          <td>'. $row["id_sensor"]. '</td>
          <td>'. $row["hour"]. ' </td>
          <td>'. $row["date"]. ' </td>
          <td>'. ltrim($row["temperature"],'0'). '</td>
          <td>'. ltrim($row["humidity"],'0'). ' </td>
          <td>'. ltrim($row["pressure"],'0'). ' </td>
          <td>'. ltrim($row["altitude"],'0'). ' </td>
          <td>'. ltrim($row["eCO2"],'0'). ' </td>
          <td>'. ltrim($row["eTVOC"],'0'). ' </td>
          </tr> ';
        }
        ?> 
      </tbody>  
    </table>  

    <table cellspacing="0" cellpadding="0" border="0">
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
  $(document).ready(function() {
    $('#tableSensors').DataTable(
    {
      "order": [],
      "language": {
        "lengthMenu": "Ver _MENU_ registos por página",
        "zeroRecords": "Nothing found - sorry",
        "info": "página _PAGE_ de _PAGES_",
        "infoEmpty": "No records available",
        "infoFiltered": "(filtered from _MAX_ total records)",
        "search":         "pesquisa:",
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







