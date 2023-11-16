<?php
//ini_set('display_errors', 0);
//error_reporting(0);



		$id = $_POST['id'];



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
	
		$pass = $_POST['psw']; 
		
		$email = $_POST['email'] ; 
		$userType = $_POST['permitions'];
	
		if (!empty($_POST['psw']))
		{
			
			$password = sha1($pass);
			$sql = "UPDATE `users` SET `username`='$username', `email`='$email', `user_type`='$userType', `password`='$password' WHERE user_id='$id'";


			if ($conn->query($sql) === TRUE) {
				
				echo "<script type='text/javascript'>
				alert('Dados de utilizador atualizados com sucesso!!')
				window.location = 'manageUser.php';</script>";

			} else {
				echo "erro na alteração da password! Tente outra vez! "  . $conn->error;
				//header("location:editUser.php?msg=failed");
			} 
			
		} else {
			$sql = "UPDATE `users` SET `username`='$username', `email`='$email', `user_type`='$userType' WHERE user_id='$id'";

			if ($conn->query($sql) === TRUE) {
				
				echo "<script type='text/javascript'>
				alert('Dados de utilizador atualizados com sucesso!')
				window.location = 'manageUser.php';</script>";

			} else {
				echo "erro na alteração da password! Tente outra vez! "  . $conn->error;
				//header("location:editUser.php?msg=failed");
			} 
			//header("location:editarDados.php?msg=failed");
			//echo "erro na alteração da password! Tente outra vez! "  . $conn->error;
			//header("location:editarDados.php?msg=failed")


		} 


	?>
