<?php
$csvPath = 'C:\\xampp\\htdocs\\ProjetoCartonagemV1\\PF'; // Certifique-se de usar o caminho correto
$fileName = 'file1.csv';

// Dados de exemplo para o arquivo CSV
$csvData = [
    ['Nome', 'Idade', 'Email'],
    ['João', 25, 'joao@email.com'],
    ['Maria', 30, 'maria@email.com'],
];

// Caminho completo para o arquivo CSV
$filePath = $csvPath . DIRECTORY_SEPARATOR . $fileName;

// Abre o arquivo CSV para escrita
$file = fopen($filePath, 'w');

if ($file !== false) {
    // Escreve os dados no arquivo
    foreach ($csvData as $data) {
        fputcsv($file, $data);
    }

    // Fecha o arquivo
    fclose($file);
    
    echo "Arquivo CSV '$fileName' foi criado com sucesso.";
} else {
    echo "Erro ao criar o arquivo CSV '$fileName'. Verifique as permissões de gravação.";
}
?>
