<?php
include('config.inc.php');

if (isset($_SESSION['username'])) {
	include('header.inc.php');
?>
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
				require 'connect.inc.php';
				
				$query = "SELECT DISTINCT l.id_sensor , IF(l.location_x IS NULL,'Localização Por Definir','Localização Definida') as location, l.status FROM location l";
				
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
<?php
	include('footer.inc.php');
}else{
	header('Location: login.php');
}