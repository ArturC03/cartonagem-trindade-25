<?php
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
		$password = $_POST['psw'] ; 
		$email = $_POST['email'] ; 
		$userType = $_POST['permitions'];
		$sqlCheck = "SELECT email FROM users WHERE email='$email'";
		$res=mysqli_query($conn,$sqlCheck);


		if (mysqli_num_rows($res) > 0)
		{
			echo "existe: " . $sqlCheck . "<br>" . $conn->error;
				// echo "<script type='text/javascript'>
				// alert('Localização Atualizada com Sucesso!')
				// window.location = 'manageSensors.php';</script>";
			}
				
		


		else if (mysqli_num_rows($res) == 0)
		{

			$sql = "INSERT INTO `users`(`username`, `email`, `user_type`, `password`) VALUES ('$username','$email','$userType','$password')";

			if ($conn->query($sql) === TRUE) {
				echo "sucesso: " . $sql . "<br>" . $conn->error;
				// echo "<script type='text/javascript'>
				// alert('Nova localização adicionada com sucesso!')
				// window.location = 'manageSensors.php';</script>";
			} else {
				echo "erro: " . $sql . "<br>" . $conn->error;
			} 

		}

?>