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

<script type="text/javascript">
    $(function() {
        $('td a#a_id').click(function() {
            return confirm("Are You sure that You want to delete this?");
        });
    });
</script>


<body style="overflow: hidden; background-color:#E0E0E0; overflow: scroll;">

	<br><br>
	<div class="container">

		<form method="post" enctype="multipart/form-data" style="background-color:#fff;  padding:20px; border-radius: 20px;" >

			<h1>Gestão de utilizadores</h1>
			<a type="button" href="AddUser.php" class="btn btn-outline-success" style="margin-bottom: 10px;">Add New User</a>
			<div class="table-responsive">
				<table class="table table-dark table-hover">
					<thead>
						<tr>
							<th width="20%"; style="text-align: center; vertical-align: middle;">Utilizador</th>
							<th width="40%"; style="text-align: center; vertical-align: middle;">Email</th>
							<th width="25%"; style="text-align: center; vertical-align: middle;">Permissões</th>
							<th width="15%"; style="text-align: center; vertical-align: middle;">Editar</th>
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
					
					$query = "SELECT user_id, username, email,  IF(user_type = '1','Admin','Utilizador') as permissoes FROM users";  
					
					$result = $mysqli->query($query);
					while($row = mysqli_fetch_array($result))  
					{   
						echo '  
						<tr> 
						<td style="text-align: center; vertical-align: middle;  font-size: 20px; "> '. $row["username"]. '</td>
						<td style="text-align: center; vertical-align: middle;  font-size: 20px; "> '. $row["email"]. '</td>  
						<td style="text-align: center;" vertical-align: middle;">'. $row["permissoes"]. ' </td> 
						<td style="text-align: center; vertical-align: middle;  font-size: 20px; ">
						<a type="button" class="btn btn-primary" style="margin-bottom:5px;" href="editUser.php?id='. $row["user_id"].'" >Edit</a>
						<a type="button" class="btn btn-danger" style="margin-bottom:5px;" id="a_id" href="deleteUser.php?id='. $row["user_id"].'" >Delete</a>
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