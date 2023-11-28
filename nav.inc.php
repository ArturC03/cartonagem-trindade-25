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

<nav class="navbar navbar-expand-lg navbar-light bg-dark" >
  <a class="navbar-brand text-light float-right" href="home.php"><?php echo $site_title ?></a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item" >
        <a href="home.php" id="home" class="nav-link text-light" href="/">Home</a>
      </li> 
      
      <li class="nav-item">
        <a href="archive2.php" id="arquivo" class="nav-link text-light" href="#">Arquivo</a>
      </li>
      <li class="nav-item">
        <a href="csvtools.php" id="csvtools" class="nav-link text-light" href="#">Gerar CSV</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-light" href="#" id="navbardrop" data-bs-toggle="dropdown"><img src="images/settings-icon.png" alt="Definições" style="width:25px;"></a>
        <div class="dropdown-menu pull-left">
          <a class="dropdown-item" href="manageSensors.php">Gerir Nós</a>
          <a class="dropdown-item" href="manageUser.php">Gerir Utilizadores</a>
          <a class="dropdown-item" href="csvtimes.php">CSV Automático</a>
          <a class="dropdown-item" href="editarDados.php">Alterar Password da Conta</a>
          <a class="dropdown-item" href="editarTitulo.php">Alterar Título</a>
        </div>
      </li>
    </ul>
  </div>
  <div class="d-flex">  
    <?php
    if(isset($_SESSION['username'])){
      echo '<a id="3" href="logout.php" class="nav-link text-light">Logout</a>"';
    }else{
      echo '<a id="3" href="login.php" class="nav-link text-light">Login</a>';
    }
    ?>
  </div>
</nav>