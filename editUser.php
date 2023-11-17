<!DOCTYPE html>

<html >
<head>
	<meta charset="utf-8">
	<script src="js/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/sensors.css">
	
</head>

<?php
//ini_set('display_errors', 0);
//error_reporting(0);

include('nav.php');

include('php/session.php');
$id = $_GET['id'];

if(!isset($_POST['completeYes']))

	{ }else{


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
		
		$username = $_POST['username'];
	
		$pass = $_POST['psw'] ; 
		
		$email = $_POST['email'] ; 
		$userType = $_POST['permitions'];
	
		if (!is_null($pass))
		{
			$sql = "UPDATE `users` SET `username`='$username', `email`='$email', `user_type`='$userType' WHERE user_id='$id'";

			if ($conn->query($sql) === TRUE) {
				
				echo "<script type='text/javascript'>
				alert('Dados de utilizador atualizados com sucesso!')
				window.location = 'manageUser.php';</script>";

			} else {
				//echo "erro na alteração da password! Tente outra vez! "  . $conn->error;
				header("location:editUser.php?msg=failed");
			} 
			//header("location:editarDados.php?msg=failed");
			//echo "erro na alteração da password! Tente outra vez! "  . $conn->error;
			//header("location:editarDados.php?msg=failed");
			
		} else {
			$password = sha1($pass);
			$sql = "UPDATE `users` SET `username`='$username', `email`='$email', `user_type`='$userType', `password`='$password' WHERE user_id='$id'";


			if ($conn->query($sql) === TRUE) {
				
				echo "<script type='text/javascript'>
				alert('Dados de utilizador atualizados com sucesso!!')
				window.location = 'manageUser.php';</script>";

			} else {
				//echo "erro na alteração da password! Tente outra vez! "  . $conn->error;
				header("location:editUser.php?msg=failed");
			} 


		} 

	} 

	?>

	<body>
		<div class="container-fluid page-container" >
			<div class="row dashboard-container" >

				<div class="col-12" style="margin-top: 2%;">
					<div class="row dashboard-rows"> 
						<div class="col-md-12 pr-md-1" >
							<?php
							require 'connect.php';
        					//error_reporting(0); 
							$mysqli = new mysqli("$servername", "$username", "$password", "$dbname");

							if ($mysqli->connect_errno) {
								echo "<p>MySQL error no {$mysqli->connect_errno} : {$mysqli->connect_error}</p>";
								exit();
							}

							$query2 = "SELECT * FROM users where user_id='$id';";  

							$result = $mysqli->query($query2);
							while($row = mysqli_fetch_array($result))  
        { 
					
							

							?>

							<form method="post" class="modal-content" enctype="multipart/form-data" action="changeUser.php" onsubmit="return confirm('Pretende alterar os dados de utilizador?');">
								<div class="container">
									<h1>Alterar dados de Utilizador</h1>
									<input type="hidden" name="id" value="<?php echo $_GET['id'];?>">
									<hr>
									<?php
									if (isset($_GET["msg"]) && $_GET["msg"] == 'failed') {
										echo '<span style="color: red;">ERRO A ALTERAR OS DADOS!!!</span>';
									} 
									?>
									<label for="email"><b>Username</b></label>
									<input type="text" value="<?php echo $row['username'];?>" placeholder="Inserir Username" name="username" id="username" required>

									<label for="email"><b>Email</b></label>
									<input type="email" value="<?php echo $row['email'];?>" placeholder="Inserir Email" name="email" id="email" required>

									<label for="psw"><b>Alterar Password</b></label><br>
									&nbsp;&nbsp;&nbsp;<input type="checkbox" onclick="SeePass()"> Ver Password<br>
									<input type="password" placeholder="Inserir Password" name="psw" id="psw" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"  >
									
									<p id="text" style="display:none; color:red;">CUIDADO! Caps lock Ligado.</p>
									<div id="message">
										<h3>A Password deve conter os seguintes requisitos:</h3>
										<p id="capital" class="invalid">Uma letra maiúscula</p>
										<p id="letter" class="invalid">Uma letra minúscula</p>
										<p id="number" class="invalid">Um Número</p>
										<p id="length" class="invalid">Pelo menos 8 caracteres</p>
									</div>

									<label for="psw-repeat"><b>Confirmar Nova Password</b></label>
									<input type="password" placeholder="Confirmar Password" name="psw-repeat" id="psw-repeat" >
									<p id="text2" style="display:none; color:red;">CUIDADO! Caps lock Ligado.</p>
									<label><b>Atribuir permissões de administrador?</b></label><br>
								
									<input type="radio" class="permitions" id="permitions" name="permitions" value="1" <?php if ($row[user_type]== '1') echo "checked";?>>Sim<br>
									<input type="radio" class="permitions" id="permitions" name="permitions" value="0" <?php if ($row[user_type]== '0') echo "checked";?>>Não<br>
									<br>

									<br>

									<div class="clearfix">
										<div class="botaoutl" style="text-align: center; width: 100%">
											<input class="btn btn-success" width="200px;" type="submit" id="submit" name="completeYes" value="Editar">
										</div><br>
									</div>
								</div>
							</form>

						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>

<?php } ?>

</body>
<script>
//VERIFICAR SE CapsLock ESTA LIGADO
var input2 = document.getElementById("psw-repeat");
var input = document.getElementById("psw");
var text = document.getElementById("text");
input.addEventListener("keyup", function(event) {

if (event.getModifierState("CapsLock")) {
    text.style.display = "block";
  } else {
    text.style.display = "none"
  }
});
var text2 = document.getElementById("text2");
input2.addEventListener("keyup", function(event) {

if (event.getModifierState("CapsLock")) {
    text.style.display = "block";
  } else {
    text.style.display = "none"
  }
});


//VER PASSWORD
function SeePass() {
  var x = document.getElementById("psw");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
  var x = document.getElementById("psw-repeat");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}

//verificar seguranca da password
var myInput = document.getElementById("psw");
var letter = document.getElementById("letter");
var capital = document.getElementById("capital");
var number = document.getElementById("number");
var length = document.getElementById("length");

// When the user clicks on the password field, show the message box
myInput.onfocus = function() {
  document.getElementById("message").style.display = "block";
}

// When the user clicks outside of the password field, hide the message box
myInput.onblur = function() {
  document.getElementById("message").style.display = "none";
}

// When the user starts to type something inside the password field
myInput.onkeyup = function() {
  // Validate lowercase letters
  var lowerCaseLetters = /[a-z]/g;
  if(myInput.value.match(lowerCaseLetters)) {  
    letter.classList.remove("invalid");
    letter.classList.add("valid");
  } else {
    letter.classList.remove("valid");
    letter.classList.add("invalid");
  }
  
  // Validate capital letters
  var upperCaseLetters = /[A-Z]/g;
  if(myInput.value.match(upperCaseLetters)) {  
    capital.classList.remove("invalid");
    capital.classList.add("valid");
  } else {
    capital.classList.remove("valid");
    capital.classList.add("invalid");
  }

  // Validate numbers
  var numbers = /[0-9]/g;
  if(myInput.value.match(numbers)) {  
    number.classList.remove("invalid");
    number.classList.add("valid");
  } else {
    number.classList.remove("valid");
    number.classList.add("invalid");
  }
  
  // Validate length
  if(myInput.value.length >= 8) {
    length.classList.remove("invalid");
    length.classList.add("valid");
  } else {
    length.classList.remove("valid");
    length.classList.add("invalid");
  }
}

var password = document.getElementById("psw"), confirm_password = document.getElementById("psw-repeat");

function validatePassword(){
  if(password.value != confirm_password.value) {
    confirm_password.setCustomValidity("Passwords Don't Match");
  } else {
    confirm_password.setCustomValidity('');
  }
}

password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;
</script>