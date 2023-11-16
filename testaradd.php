<?php
//ini_set('display_errors', 0);
//error_reporting(0);


include('php/session.php');

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
		$passO =$_POST['psw-old']; 

		$passOld=sha1($passO);
		$pass = $_POST['psw'] ; 
		$password = sha1($pass);

		$sqlCheck = "SELECT * FROM users WHERE  password LIKE '{$passOld}' and email LIKE '{$session_id}'";
		$res=mysqli_query($conn,$sqlCheck);
				
		
	
		if (mysqli_num_rows($res) > 0)
		{

			$sql = "UPDATE `users` SET`password`='$password' WHERE email='$session_id'";

			if ($conn->query($sql) === TRUE) {
				
				echo "<script type='text/javascript'>
				alert('Password atualizada com sucesso!')
				window.location = 'manageUser.php';</script>";
			} else {
				echo "erro na alteração da password! Tente outra vez! "  . $conn->error;
			} 
			//header("location:editarDados.php?msg=failed");
			header("location:login.php?msg=failed");
			//echo "erro na alteração da password! Tente outra vez! "  . $conn->error;
			//header("location:editarDados.php?msg=failed");
			
		}


		else if (mysqli_num_rows($res) == 0)
		{
			header("location:login.php?msg=failed");
			//echo "erro na alteração da password! Tente outra vez! "  . $conn->error;

		}


	} 

	?>
