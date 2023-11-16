<?php
// Configurações de conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "plantdb";

// Mapeamento de arquivos CSV para consultas SQL
$fileToQuery = [
    'file1.csv'=> "SELECT DISTINCT temperature, humidity, pressure, altitude, eCO2, eTVOC 
                   FROM sensors 
                   WHERE id_sensor IN ('0102', '0103', '0104', '0107', '0108', '0109')"
];

// Caminho para salvar os arquivos CSV
$csvPath = 'C:\\xampp\\htdocs\\ProjetoCartonagemV1\\PF';

// Conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

foreach ($fileToQuery as $fileName => $sql) {
    $filePath = $csvPath . $fileName;
    
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Abre o arquivo CSV para escrita (ou cria se não existir)
        $file = fopen($filePath, 'a');
        
        // Escreve os dados no arquivo
        while ($row = $result->fetch_assoc()) {
            fputcsv($file, $row);
        }
        
        // Fecha o arquivo
        fclose($file);
    } else {
        echo "Nenhum dado encontrado para a consulta de $fileName.";
    }
}

// Fecha a conexão com o banco de dados
$conn->close();

// Você pode descomentar esta linha para definir o intervalo de 5 horas:
// sleep(5 * 60 * 60);
?>
