<!DOCTYPE html>
<meta charset="utf-8">
<html >
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href=" https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

<?php

include('nav.inc.php');
include('connect.php');


//ver sombra do form
?>
<html>
  
  <style>
    /* 64ac15 */
*,
*:before,
*:after {
  box-sizing: border-box;
}
form {
  /*margin-right: 720px;*/
  
  padding: 30px;
  font-family: "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
  font-size: 15px;
  color: black;
  border-radius: 20px;
  background: lightgrey;
  box-shadow: 0px 0px 30px #83888e;
  
}
h2 {
  color: #000000;
  font-size: 28pt;
  text-align: center;
  text-shadow: 2px 2px 5px grey;
 
}
input[type="text"]{
  margin-left: 15px;
  margin-right: 10px;
  position: relative;
  width: 350px;
  padding: 1em;
 
  background-color: #f9f9f9;
  border: 1px solid #e5e5e5;
  border-radius: 12px;
}
input[type="date"]{
  margin-left: 15px;
  position: relative;
  width: 350px;
  padding: 1em;
  
  background-color: #f9f9f9;
  border: 1px solid #e5e5e5;
  border-radius: 12px;
}
input[type="time"]{
  margin-left: 15px;
  position: relative;
  width: 350px;
  padding: 1em;
 
  background-color: #f9f9f9;
  border: 1px solid #e5e5e5;
  border-radius: 12px;
}
input:focus {
  outline: 0;
  border-color: #bd8200;
}
input:focus + .input-icon i {
  color: #f0a500;
}
input:focus + .input-icon:after {
  border-right-color: #f0a500;
}
label{
  line-height: 45px;
  margin-left: 10px;
}
input[type="submit"]{
  width: 200px;
  background: #2e2929;
  color: #fff;
  border: 1px solid #2e2929;
  border-radius: 20px;
  box-shadow: 0px 0px 10px black;
  text-shadow: none;
  height: 50px;
  width: 150px;

}
input[type="submit"]:hover{
  background: #999999;
  color: #ffffff;
  border: 1px solid #eee;
  border-radius: 20px;
  box-shadow: 5px 5px 5px #eee;
  text-shadow: none;

}
input[type="reset"]{
  margin-top: 15px;
  width: 200px;
  background: #2e2929;
  color: #fff;
  border: 1px solid #2e2929;
  border-radius: 20px;
  box-shadow: 0px 0px 10px black;
  text-shadow: none;
  height: 50px;
  width: 150px;
}
input[type="reset"]:hover{
  background: #999999;
  color: #ffffff;
  border: 1px solid #eee;
  border-radius: 20px;
  box-shadow: 5px 5px 5px #eee;
  text-shadow: none;
}

.abc{
  /*margin-left: 600px;*/
  display: flex;
  padding: 40px 0;
  justify-content: left;
  height: 780px;
  margin-top: 6vh; 
}
.imagem{
  display: flex;
  margin-left: 35px;
  justify-content: right;
  padding: 17px;
  background: lightgrey; 
  border-radius: 20px;
  box-shadow: 0px 0px 30px #83888e;

}
@media screen and (max-width: 1300px){
  .abc{
    margin-top: -15px;
    height: 650px;
    padding-top: 20px;
    padding-bottom: 10px;
  }
  form{
    padding: 20px;
    padding-top: 10px;
    width: 250px;
    padding-bottom: 0;
  }
  input{
    height: 50px;
  }
  input[type="text"]{
    width: 160px;
  }
  input[type="date"]{
    width: 160px;
  }
  input[type="time"]{
    width: 160px;
  }
  label{
    margin-top: 8px;
    margin-bottom: 3px;
    line-height: 35px;
    margin-left: 10px;
  }
  input[type="submit"]{
    height: 37px;
    width: 150px;
    margin-top: -5px;
    margin-left: 20px;
  }
  input[type="reset"]{
    height: 37px;
    width: 150px;
    margin-top: -3px;
    margin-left: 7px;  
  }
  
  .imagem{
    margin-left: 20px;
    display: block;
    height: 387px;
  }
  img{
    width: 700px;
    height: auto;
    object-fit: cover;
  }
}
select {
  margin-left: 15px;
  margin-right: 10px;
  position: relative;
  width: 350px;
  padding: 1em; 
  font-size: 16px;
  border: 1px solid #ccc;
  border-radius: 4px;
  background-color: #fff;
  box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
}

select:focus {
  outline: none;
  border-color: #6d9eeb;
  box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1), 0 0 8px rgba(109, 158, 235, 0.6);
}

option {
  font-size: 16px;
}
*/
</style>
<body>

    <script>
    function altera2(){
      
      window.location.href = "consultaTabela.php";
    }
    
  
    </script>
    <?php
  
  ?>  
    <br>
    <!--<h2> Filtrar por: </h2>-->
    <div class="abc">
      <form name="form01" method="POST" action="consultaTabela.php" style="margin-left: 40px; height:850px">
        <label for="sensor">Nó da rede: </label> <br>
        <input type="text" id="sensor" name="text1" required>
	      <div id="dropdown-container"></div>
        <label for="mindata">Data Mínima: </label> <br>
        <input type="date" id="mindata" name="text2" required value="<?php echo date('Y-m-d') ?>"> <br>
        <label for="maxdata">Data Máxima: </label> <br>
        <input type="date" id="maxdata" name="text3" required value="<?php echo date('Y-m-d') ?>"> <br>
        <label for="minhora">Hora Mínima: </label> <br>
        <input type="time" id="minhora" name="hora1"><br>
        <label for="maxhora">Hora Máxima: </label> <br> 
        <input type="time" id="maxhora" name="hora2" > <br><br>
        &nbsp&nbsp <input type="reset" id="reset"> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
        <input type="submit" id="submit" name="submeter">
      </form>
      <div class="imagem">
        <img src="images/plantaV2.png" width="auto" height="auto">
      </div>
    </div>
    <?php

    

    ?>
  <script>

function limitarSelecoes(selectElement, maxSelecoes) {
  var selecoes = selectElement.selectedOptions.length;
  if (selecoes > maxSelecoes) {
    for (var i = 0; i < selectElement.options.length; i++) {
      if (!selectElement.options[i].selected) {
        selectElement.options[i].disabled = true;
      }
    }
  } else {
    for (var i = 0; i < selectElement.options.length; i++) {
      selectElement.options[i].disabled = false;
      }
    }
}
</script>
 <script>
  function toggleSelect() {
    var select = document.querySelector('select[name="ids[]"]');
    if (select.style.display === 'none') {
      select.style.display = 'block';
    } else {
      select.style.display = 'none';
    }
  }   
</script>
<script>
		function mostrarDropdown() {
			// Obter o código HTML do dropdown gerado pelo PHP
			var dropdownHTML = '<?php 
			        $consulta = mysqli_query($conn,"SELECT id_sensor,sensor_id FROM sensors");
			        echo "<br><select name=\'ids[]\'  multiple onchange=\'limitarSelecoes(this, 2)\'>";
			        while ($resultado = mysqli_fetch_assoc($consulta)) {
			          echo "<option value=\'" . $resultado["id_sensor"] . "\'>" . $resultado["id_sensor"] . "</option>";;
			        }
			        echo "</select>";
			        ?>';
			// Adicionar o dropdown ao container na página
			document.getElementById("dropdown-container").innerHTML = dropdownHTML;
		}
	</script>
  

  
</body>
</html>

