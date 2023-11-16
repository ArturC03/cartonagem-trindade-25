<!DOCTYPE html>

<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/sensors.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/DragDrop.css">
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
</head>
<?php
ini_set('display_errors', 0);
//error_reporting(0);

include('nav.php');

if (!isset($_POST['completeYes'])) {
} else {


	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "plantdb";



	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$id_exists = false;
	$id_sensor = $_POST['id'];
	$location_x = $_POST['location_x'];
	$location_y = $_POST['location_y'];
	$sqlCheck = "SELECT id_sensor FROM location WHERE id_sensor='$id_sensor'";
	$res = mysqli_query($conn, $sqlCheck);


	if (mysqli_num_rows($res) > 0) {
		$sql = "UPDATE `location` SET `location_x`='$location_x',`location_y`='$location_y' where `id_sensor` = '$id_sensor';";

		if ($conn->query($sql) === TRUE) {
			echo "<script type='text/javascript'>
				alert('Localização Atualizada com Sucesso!')
				window.location = 'manageSensors.php';</script>";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	} else if (mysqli_num_rows($res) == 0) {

		$sql = "INSERT INTO location (location_x, location_y, id_sensor) VALUES 
			('$location_x', '$location_y','$id_sensor' )";

		if ($conn->query($sql) === TRUE) {
			echo "<script type='text/javascript'>
				alert('Nova localização adicionada com sucesso!')
				window.location = 'manageSensors.php';</script>";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}
}

?>


<script>
	
	var el = document.getElementById('myCoolForm');

	el.addEventListener('submit', function() {
		return confirm('');
	}, false);
</script>
<!-- action="sendLocation.php?id=<?php echo $id_sensor; ?>" -->

<body>
	<div class="container-fluid page-container">
		<div class="row dashboard-container">

			<div class="col-12" style="margin-top: 2%;">
				<div class="row dashboard-rows">
					<div class="col-md-12 pr-md-1">
						<div class="graph-containers" style=" ">
							<form method="post" id="SetLocation" name="SetLocation" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="return confirm('Pretende guardar a nova localização?');">
								<div class="SetLocation" style=" overflow-x: auto;  white-space: nowrap; margin-right: 10%; margin-left: 10%;">
									<div style=" display: table;  margin: 0 auto;">

										<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">

										<input type="hidden" name="location_x" id="location_x">
										<input type="hidden" name="location_y" id="location_y">
										<br>
										<h1 align="center" style="border-bottom: 5px solid #a06845;">Definir Localização para o nó <?php echo $_GET['id']; ?></h1>
									</div><br>
									<div style="display: flex; flex-direction: row; flex-wrap: wrap; justify-content: center; align-items: center;">
										<h2>Arraste o alvo para a localização desejada: &nbsp;</h2>


										<div data-id="1" class="draggable" style="background-color: black; background: url(images/targetGreen.png) no-repeat; background-position: center left; background-size: 30% auto;">
											<!-- <p style="padding-left: 25%;"></p> -->
										</div>

									</div>
									<div id='heatMap1'style=" width:200%; height:820; min-height: 552px; max-height: auto;  padding: 3px;  margin: 0 auto; display: block;   ">
									<script>
  // Função para verificar a resolução da tela e atualizar a largura do elemento
  function checkScreenResolution() {
    var screenWidth = window.screen.width;
    var screenHeight = window.screen.height;
    var divElement = document.getElementById("heatMap1");

    // Verifica se a resolução da tela é menor que 1024x768
    if (screenWidth < 1100 || screenHeight < 800) {
      divElement.style.width = "200%";
    }
    // Caso contrário, define a largura como 100%
    else {
      divElement.style.width = "100%";
    }
  }

  // Chama a função de verificação quando a janela é redimensionada
  window.addEventListener("resize", checkScreenResolution);

  // Chama a função de verificação quando a página é carregada
  window.addEventListener("load", checkScreenResolution);
</script>
										<?php
										require 'php/connect.php';
										$id = $_GET['id'];
										$mysqli = new mysqli("$servername", "$username", "$password", "$dbname");
										$sqlC = "SELECT location_x,location_y  FROM location WHERE id_sensor='$id'";
										$result = $mysqli->query($sqlC);
										while ($row = mysqli_fetch_array($result)) {
											$x = $row['location_x'] ;
											$y = $row['location_y'] ;
										}
										?>
										<img src='images/target.png' style="left: <?php echo $x; ?>px; top: <?php echo $y; ?>px;  z-index: 3; position: relative;" width=" 40 auto;" />
										<img id="droppable" src='images/plantaV2.png' width="1387" height="682" />
									</div>

								</div>
								<div class="botaoutl" style="text-align: center; width: 100%">
									<input class="btn btn-success" width="150px;" type="submit" id="submit" name="completeYes" value="Guardar">
								</div><br>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>

<!-- code for drag and drop -->
<script type="text/javascript">
	$(function() {
		var pos = null;
		var parent = null;
		var current = null;
		$(".draggable").draggable({
			drag: function() {
				pos = $(this).offset();
				parent = $("#droppable").offset();
				current = {
					left: pos.left- parent.left,
					top: pos.top - parent.top
				};

				var location_x = current.left;
				var location_y = current.top;




				var location_x = JSON.stringify(location_x);
				$("#location_x").val(location_x);

				var location_y = JSON.stringify(location_y);
				$("#location_y").val(location_y);

			}
		});

		$("#droppable").droppable({
			drop: function(event, ui) {
				$(this)
					.addClass("ui-state-highlight")
					.find("p")
					.html("Dropped!");
				$.ajax({
					method: "POST",
					url: "insert.php",
					data: {
						name: current.left,
						location: current.top
					}
				})

			}

		});
	});

	function myFunction() {
		var txt;
		if (confirm("Press a button!")) {
			txt = "You pressed OK!";
		} else {
			txt = "You pressed Cancel!";
		}
		document.getElementById("demo").innerHTML = txt;
	}

	function SuccessMessage() {}
</script>