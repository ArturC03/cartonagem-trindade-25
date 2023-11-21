<?php
if (isset($_SESSION['username'])) {
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<?php
//error_reporting(0);
ini_set('display_errors', 0);
include('nav.inc.php');

?>



<body style="overflow: hidden; background-color:#E0E0E0; overflow-y: scroll;">

<br><br>
	<div class="container">

		<form method="post" enctype="multipart/form-data" style="background-color:#fff;  padding:20px; border-radius: 20px;" >

			<h1>Gestão de Nós</h1>
			<br>
			  <div class="table-responsive">
			<table class="table table-dark table-hover">
				<thead>
					<tr>
						<th width="20%"; style="text-align: center; vertical-align: middle;">ID do Nó</th>
						<th width="50%"; style="text-align: center; vertical-align: middle;">Localização</th>
						<th width="15%"; style="text-align: center; vertical-align: middle;">Editar</th>
						<th width="15%"; style="text-align: center; vertical-align: middle;" >Alterar Estado</th>
					</tr>
				</thead>   
				<?php  
				require 'connect.php';
				//error_reporting(0); 
				$mysqli = new mysqli("$servername", "$username", "$password", "$dbname");
				
				if ($mysqli->connect_errno) {
					echo "<p>MySQL error no {$mysqli->connect_errno} : {$mysqli->connect_error}</p>";
					exit();
				}
				
				//$query= "SELECT DISTINCT id_sensor from location";
				
				$query = "SELECT DISTINCT l.id_sensor , IF(l.location_x IS NULL,'Localização Por Definir','Localização Definida') as location, l.status FROM location l";
				//ORDER BY s.id_sensor";  
				
				//$query = "SELECT DISTINCT s.id_sensor , IF(l.location_x IS NULL,'Localização Por Definir','Localização Definida') as location, l.status FROM sensors s LEFT JOIN location l ON s.id_sensor = l.id_sensor ORDER BY s.id_sensor";  
				
				
				$result = $mysqli->query($query);
				while($row = mysqli_fetch_array($result))  
				{   
					echo ' 
					<tr> 
					<td style="text-align: center; vertical-align: middle;  font-size: 20px; "> '. $row["id_sensor"]. '</td> 
					<td style="text-align: center;" vertical-align: middle;">'. $row["location"]. ' </td> 
					<td style="text-align: center; vertical-align: middle;  font-size: 20px; ">
					<a type="button" class="btn btn-primary" href="EditLocation.php?id='. $row["id_sensor"].'" >Edit</a>
					</td> 
					<td style="text-align: center; vertical-align: middle;  font-size: 20px; ">
					<a type="button" class="btn btn-primary"  href="ChangeSensorStatus.php?id='. $row["id_sensor"].'&status='. $row["status"].'">'
					; 
					
					
						if($row["status"] == 1)
						{ echo "Activo" ;
						}
						else { echo "Inativo";
						}
						echo
						'</a>
						</td>  
						</tr>  
						';  
					}  
					?>  
			</table>  
		</div>
		</form>


	</div> 
</body>
</html>
<?php
}else{
	header('Location: login.php');
}