<?php
session_start();

// Configurações do Supabase
$supabaseUrl = 'https://kdsuvlaeepwjzqnfvxxr.supabase.co';
$supabaseKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Imtkc3V2bGFlZXB3anpxbmZ2eHhyIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NTYxNTMwMTIsImV4cCI6MjA3MTcyOTAxMn0.iuOiaoqm3BhPyEMs6mtn2KlA2CIuYdnkcfmc36_Z8t8';
$tabela = 'admins';

// Dados do formulário
$nome  = trim($_POST['nome'] ?? '');
$cpf   = trim($_POST['cpf'] ?? '');
$email = trim($_POST['email'] ?? '');
$senha = trim($_POST['senha'] ?? '');

if ($nome === '' || $cpf === '' || $email === '' || $senha === '') {
    $_SESSION['erro_cadastro'] = "Preencha todos os campos!";
    header("Location: cadastro-adm.php");
    exit();
}

// Gera hash seguro
$senhaHash = password_hash($senha, PASSWORD_BCRYPT);

// Verifica se já existe admin com mesmo email ou CPF
$checkUrl = "$supabaseUrl/rest/v1/$tabela?email=eq.$email&cpf=eq.$cpf";

$ch = curl_init($checkUrl);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "apikey: $supabaseKey",
    "Authorization: Bearer $supabaseKey",
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$checkResponse = curl_exec($ch);
curl_close($ch);

$existe = json_decode($checkResponse, true);

if (!empty($existe)) {
    $_SESSION['erro_cadastro'] = "Email ou CPF já cadastrados!";
    header("Location: cadastro-adm.php");
    exit();
}

// Prepara dados
$dados = [
    "nome"  => $nome,
    "cpf"   => $cpf,
    "email" => $email,
    "senha" => $senhaHash
];

$payload = json_encode($dados);

// URL do INSERT
$url = "$supabaseUrl/rest/v1/$tabela";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "apikey: $supabaseKey",
    "Authorization: Bearer $supabaseKey",
    "Content-Type: application/json",
    "Content-Profile: public",
    "Prefer: return=representation, resolution=merge-duplicates"
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Verifica resultado
if ($httpCode >= 200 && $httpCode < 300) {
    $_SESSION['sucesso_cadastro'] = "Administrador cadastrado com sucesso!";
} else {
    $_SESSION['erro_cadastro'] = "Erro ao cadastrar: $response (HTTP $httpCode)";
}

header("Location: cadastro-adm.php");
exit();
?>
