<?php
session_start();

// Configurações do Supabase
$supabaseUrl = 'https://kdsuvlaeepwjzqnfvxxr.supabase.co';
$supabaseKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Imtkc3V2bGFlZXB3anpxbmZ2eHhyIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NTYxNTMwMTIsImV4cCI6MjA3MTcyOTAxMn0.iuOiaoqm3BhPyEMs6mtn2KlA2CIuYdnkcfmc36_Z8t8';
$tabela = 'admins';

// Recebe dados do formulário
$nome  = $_POST['nome']  ?? '';
$cpf   = $_POST['cpf']   ?? '';
$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

// Hash da senha para segurança (não armazene a senha em texto claro!)
$senhaHash = password_hash($senha, PASSWORD_BCRYPT);

// Monta os dados para enviar
$dados = [
    "nome"  => $nome,
    "cpf"   => $cpf,
    "email" => $email,
    "senha" => $senhaHash
];

// Converte para JSON
$payload = json_encode($dados);

// URL do Supabase REST
$url = $supabaseUrl . "/rest/v1/$tabela";

// Envia requisição cURL
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "apikey: $supabaseKey",  // A chave de API é necessária
    "Authorization: Bearer $supabaseKey",  // Inclua o Bearer token
    "Content-Type: application/json",  // Definindo o tipo de conteúdo como JSON
    "Prefer: return=representation"   // Retorna o item inserido após a requisição
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Desativa verificação SSL (apenas teste, não faça em produção)
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Verifica resultado
if ($httpCode >= 200 && $httpCode < 300) {
    $_SESSION['sucesso_cadastro'] = "Cadastro realizado com sucesso!";
} else {
    $_SESSION['erro_cadastro'] = "Erro ao cadastrar no Supabase: $response (HTTP $httpCode)";
}

// Redireciona de volta
header("Location: cadastro-adm.php");
exit();
?>
