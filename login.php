<?php
@session_start();

if (isset($_SESSION['username'])) {
	header('Location: index.php');
}else{
	if (!isset($_POST['submit'])){
		?>
		<html>
		<head>
			<link rel="stylesheet" type="text/css" href="css/stylelogin.css">

		</head>
		<body style="background-image: url('images/cartonagem.jpg');  background-color: rgba(0,0,0,0.5);">
			<div class="caixa-form" style="background-color: #fff;">


				<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
					<div class="divproc1">
						<h3 style="color:#a06845; ">LOGIN</h3>
						<?php
						if (isset($_GET["msg"]) && $_GET["msg"] == 'failed') {
							echo '<span style="color: red;">USERNAME / PASSWORD ERRADO!!!</span>';
						} 
						?>

						<div class="form-inp" style="border-bottom: 1px solid #e6e6e6;">
							<a style="font-size:14px; font-family: Ubuntu-Regular;font-size: 20px;  color: #555555; ">EMAIL:</a>
							<input type="text" name="username" required style="font-family: Ubuntu-Regular;  font-size: 20px;  color: #555555;" />
						</div>
						<div class="form-inp" style="border-bottom: 1px solid #e6e6e6;">
							<a style="font-size:14px;  font-family: Ubuntu-Regular;font-size: 20px;  color: #555555;" >PASSWORD:</a>
							<input type="password" name="password" required style="font-family: Ubuntu-Regular;  font-size: 20px;  color: #555555;"/>
						</div>

						<div class="botao">
							<input type="submit" class="submit" name="submit" value="Login" />
						</div>
						<br>
						<a href="forgotPass.php" style="float: right; font-family: Ubuntu-Regular;font-size: 18px;  color: #555555;">Esqueceste-te da tua password?</a>
					</div>
				</form>
				<?php
	} else {
		require 'connect.php';

		$mysqli = new mysqli("$servername", "$username", "$password", "$dbname");

		if ($mysqli->connect_errno) {
			echo "<p>MySQL error no {$mysqli->connect_errno} : {$mysqli->connect_error}</p>";
			exit();
		}

		session_start();
		$username = $_POST['username'];
		$pass = $_POST['password'];


		$password = sha1($pass);


		$sql = "SELECT * from users WHERE email LIKE '{$username}' AND password LIKE '{$password}' LIMIT 1;";
		$result = $mysqli->query($sql);
		$row=mysqli_fetch_array($result);


		if (!$result->num_rows == 1) {
			header("location:login.php?msg=failed");




		} else {
			$_SESSION['username']=$row['email'];
			echo header('location: home.php');

		}
	}
}
?>