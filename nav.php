<?php
ini_set('display_errors', 0);
include('connect.php'); 

$mysqli = new mysqli($servername, $username, $password, $dbname);
$sql = "SELECT * from users WHERE email='$session_id';";
$result = $mysqli->query($sql);
$row=mysqli_fetch_array($result);
$user_type=$row['user_type'];

$mysqli = new mysqli("$servername", "$username", "$password", "$dbname");
  if ($mysqli->connect_errno) { 
    echo "<p>MySQL error no {$mysqli->connect_errno} : {$mysqli->connect_error}</p>";
    exit();
  }
  $sql = "SELECT titulo from titulo WHERE id=(select max(id) from titulo);";  
        
  $result = $mysqli->query($sql);
  while($row = mysqli_fetch_array($result)){
    $tit= $row['titulo'];
  }
  
  ?>
  <style>
    .nav-link{
      text-align: center;
    }
  </style>
  <?php

  $full = (isset ($_SERVER ["HTTPS"])) . $_SERVER ["HTTP_HOST"] . $_SERVER ["REQUEST_URI"];
  $full = strtok($full, "?");

  switch ($full){
    case 'localhost/ProjetoCartonagemV1/PF/home.php':
      ?>
      <style>
        #home{
          border: 1px solid white;
        }
      </style>
      <?php
      break;
    case 'localhost/ProjetoCartonagemV1/PF/archive2.php':
    ?>
    <style>
      #arquivo{
        border: 1px solid white;
      }
    </style>
     <?php
      break;
    case 'localhost/ProjetoCartonagemV1/PF/csvtools.php':
    ?>
    <style>
      #csvtools{
        border: 1px solid white;
      }
    </style>
    <?php
      break;
    default:
      
      break;
  }

?>


<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<nav class="navbar navbar-expand-lg navbar-light bg-dark" >
  <a [routerLink]="['/home']" class="navbar-brand text-light float-right" href="home.php"><?php echo $tit ?></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse " id="navbarNavDropdown">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active" >
        <a  href="home.php"  routerLinkActive='active' id="home" class="nav-link text-light" href="/">Home <span class="sr-only">(current)</span></a>
      </li> 
      
      <li class="nav-item">
        <a href="archive2.php" id="arquivo" class="nav-link text-light" href="#">Arquivo</a>
      </li>
      <li class="nav-item">
        <a href="csvtools.php" id="csvtools" class="nav-link text-light" href="#">Geração CSV</a>
      </li>
       <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle text-light" href="#" id="navbardrop" data-toggle="dropdown"><img src="images/settings-icon.png" alt="Definições" style="width:25px;"></a>
      <div class="dropdown-menu pull-left">
        <a class="dropdown-item" href="manageSensors.php">Gerir Nós</a>
        <a class="dropdown-item" href="manageUser.php">Gerir Utilizadores</a>
        <a class="dropdown-item" href="csvtimes.php">CSV Automatico</a>
         <a class="dropdown-item" href="editarDados.php">Alterar Password da conta</a>
         <a class="dropdown-item" href="editarTitulo.php">Alterar Título</a>
      </div>
    </li>


    </ul>
    <ul class="navbar-nav">
      <li><a id="3" href="logout.php" style="color: aliceblue;"></span> Logout</a></li>
    </ul>
  </div>
</nav>