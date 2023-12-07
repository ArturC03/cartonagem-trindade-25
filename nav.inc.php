<script src="js/nav.js"></script> 

<div class="full-menu">
  <div class="menu">
    <ul>
      <li><a href="home.php">Home</a></li>
      <li><a href="archive2.php">Arquivo</a></li>
      <li><a href="csvtools.php">CSV</a></li>
    </ul>
  </div>

  <div class="icons">
    <div>
      <img id="dropbtn1" class="dropbtn" src="images/toolbox.svg" alt="">
      <div id="dropdown1" class="dropdown-content">
        <a href="manageSensors.php">Gerir Nós</a>
        <a href="manageUser.php">Gerir Utilizadores</a>
        <a href="csvtimes.php">CSV Automático</a>
        <a href="editarDados.php">Alterar Password da Conta</a>
        <a href="editarTitulo.php">Alterar Título</a>
      </div>
    </div>
    <div>
      <img id="dropbtn2" class="dropbtn" src="images/user.svg" alt="">
      <div id="dropdown2" class="dropdown-content">
        <?php
        if(isset($_SESSION['username'])){
          echo '<a href="manageUser.php">' . $_SESSION['username'] . '</a>';
          echo '<a href="logout.php">Logout</a>';
        }else{
          echo '<a href="login.php">Login</a>';
        }
        ?>
      </div>
    </div>
  </div>
</div>