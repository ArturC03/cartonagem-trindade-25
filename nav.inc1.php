<?php
  $full = (isset ($_SERVER ["HTTPS"])) . $_SERVER ["HTTP_HOST"] . $_SERVER ["REQUEST_URI"];
  $full = strtok($full, "?");

  switch ($full){
    case 'localhost/ProjetoCartonagemV1/PF/home.php':
      break;
    case 'localhost/ProjetoCartonagemV1/PF/archive2.php':
      break;
    case 'localhost/ProjetoCartonagemV1/PF/csvtools.php':
      break;
    default:
      break;
  }

?>

<script src="js/nav.js"></script> 

<div class="full-menu">
  <div class="menu">
    <ul>
      <li><a href="home.php">Home</a></li>
      <li><a href="archive2.php">Arquivo</a></li>
      <li><a href="csvtools.php">CSV</a></li>
    </ul>
  </div>

  <div>
    <img class="dropbtn" src="images/toolbox.svg" alt="" onclick="Dropdown_content()">
    <div id="dropdown" class="dropdown-content">
      <a href="manageSensors.php">Gerir Nós</a>
      <a href="manageUser.php">Gerir Utilizadores</a>
      <a href="csvtimes.php">CSV Automático</a>
      <a href="editarDados.php">Alterar Password da Conta</a>
      <a href="editarTitulo.php">Alterar Título</a>
    </div>
  </div>
</div>