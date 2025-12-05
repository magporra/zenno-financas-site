<?php
session_start();

// Configurações do Supabase
$supabaseUrl = 'https://kdsuvlaeepwjzqnfvxxr.supabase.co';
$supabaseKey =  'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Imtkc3V2bGFlZXB3anpxbmZ2eHhyIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NTYxNTMwMTIsImV4cCI6MjA3MTcyOTAxMn0.iuOiaoqm3BhPyEMs6mtn2KlA2CIuYdnkcfmc36_Z8t8';
$tabela = 'admins';

// Recebe dados do formulário
$cpf = trim($_POST['cpf']);
$senha = trim($_POST['senha']);

// Busca no Supabase
$url = $supabaseUrl."/rest/v1/$tabela?cpf=eq.$cpf";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "apikey: $supabaseKey",
    "Authorization: Bearer $supabaseKey",
    "Content-Type: application/json"
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);

// Verifica se encontrou o usuário
if(!empty($data)) {

    $senhaHash = $data[0]['senha'];

    // VERIFICA A SENHA
    if (password_verify($senha, $senhaHash)) {

        // Salva CPF e NOME
        $_SESSION['adm_logado'] = $data[0]['cpf'];
        $_SESSION['nome_adm'] = $data[0]['nome'];  // 👈 AQUI ESTÁ O NOME

        header('Location: tela-adm.php');
        exit;

    } else {
        $_SESSION['erro_login'] = "Senha incorreta!";
        header('Location: login-adm.php');
        exit;
    }

} else {
    $_SESSION['erro_login'] = "CPF não encontrado!";
    header('Location: login-adm.php');
    exit;
}
?>
