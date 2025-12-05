<?php
// Dados de acesso ao banco
$host     = "localhost";     // ou o IP do seu servidor
$usuario  = "root";          // seu usuário do MySQL
$senha    = "";              // senha do MySQL
$banco    = "adm_login"; // nome do banco criado

// Cria a conexão
$conn = new mysqli($host, $usuario, $senha, $banco);

// Verifica se houve erro
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Define o charset para evitar problemas com acentuação
$conn->set_charset("utf8mb4");
?>
