<!DOCTYPE html>
<html>

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

<body style="overflow-y: hidden ;">
    <div class="container-fluid page-container">
        <div class="row dashboard-container">

            <div class="col-12" style="margin-top: 2%;">
                <div class="row dashboard-rows">
                    <div class="col-md-12 pr-md-1">
                        <div class="graph-containers" style=" ">
                            <form method="post" id="SetLocation" name="SetLocation" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="return confirm('Pretende guardar a nova localização?');" >
                                <div class="SetLocation" style=" overflow-x: auto;  white-space: nowrap; margin-right: 10%; margin-left: 10%;width: 820px;height: 780px;">
                                    <div style=" display: table;  margin: 0 auto;">
                                        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                                        <input type="hidden" name="location_x" id="location_x">
                                        <input type="hidden" name="location_y" id="location_y">
                                        
                                        <h2 align="center" style="border-bottom: 0px solid #a06845; margin-bottom: 0px;">Definir Localização para o nó <?php echo $_GET['id']; ?></h2>
                                    </div>
                                    <div id="heatMap1" style="width: 811px; height: 650px; margin: 0 auto; overflow: hidden; display:flex">
<?php
                                        require 'php/connect.php';
                                        $id = $_GET['id'];
                                        $mysqli = new mysqli("$servername", "$username", "$password", "$dbname");
                                        $sqlC = "SELECT location_x,location_y  FROM location WHERE id_sensor='$id'";
                                        $result = $mysqli->query($sqlC);
                                        while ($row = mysqli_fetch_array($result)) {
                                            $x = $row['location_x'];
                                            $y = $row['location_y'];
                                        }
                                        ?>
                                        <img id="droppable" src="images/plantaV3.png" style="width:811px;height:650px; margin-top: 0px;" />
                                        <div id="clickableArea" style="position: absolute;width: 811px;height: 650px;"></div>
                                    </div>
                                </div>
                                <input class="btn btn-success" width="150px;" type="submit" id="submit" name="completeYes" value="Guardar" style="position:absolute; bottom: 85px;right: 450px;">    
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<!-- code for click and display circle -->
<script type="text/javascript">
    $(function() {
        var droppableOffset = $("#droppable").offset();
        var droppableWidth = $("#droppable").width();
        var droppableHeight = $("#droppable").height();
        var circle;

        $("#clickableArea").on("click", function(event) {
            var x = event.pageX - droppableOffset.left;
            var y = event.pageY - droppableOffset.top;

            if (x >= 0 && x <= droppableWidth && y >= 0 && y <= droppableHeight) {
                $("#location_x").val(x);
                $("#location_y").val(y);
                if (circle) {
                    circle.remove();
                }
                showCircle(x, y);
            }
        });

        function showCircle(x, y) {
            circle = $("<div class='circle'></div>").css({
                left: x + "px",
                top: y + "px"
            });
            $("#clickableArea").append(circle);
        }
    });
</script>

<style>
    .circle {
		width: 25px;
  height: 25px;
  border-radius: 50%;
  background-color: transparent;
  border: 3px solid green;
  position:absolute;
    }
</style>

</html>
