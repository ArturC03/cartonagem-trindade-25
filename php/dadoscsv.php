<?php
// Conecta ao banco de dados
$conn = new mysqli('localhost', 'root', '', 'plantdb');

// Checa se a conexão foi bem sucedida
if ($conn->connect_error) {
  die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}


// Consulta ao banco de dados
$query = "SELECT temperature, date, sensors_id FROM sensors";
$resultado = $conn->query($query);

// Cabeçalho do arquivo CSV
$cabecalho = "Temperature,Data,Sensors\n";

// Loop pelos dados da consulta
$linhas = '';
while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {
    $linha = array($registro['temperature'], $registro['date'], $registro['sensors_id']);
    $linhas .= implode(',', $linha) . "\n";
}

// Concatena o cabeçalho com as linhas dos dados
$csv = $cabecalho . $linhas;

// Escreve o arquivo CSV
file_put_contents('arquivo.csv', $csv);
?>
