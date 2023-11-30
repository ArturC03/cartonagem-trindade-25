<?php
include('config.inc.php');
// Recupere os dados do usuário do formulário
$sensoresSelecionados = $_POST['sensores'];
$horaSelecionada = $_POST['horaSelecionada'];

// Salve os dados do usuário em um arquivo (por exemplo, user_data.txt)
$userData = [
    'sensores' => $sensoresSelecionados,
    'horaSelecionada' => $horaSelecionada,
];

file_put_contents("user_data.txt", serialize($userData)); // Salve os dados serializados
?>
