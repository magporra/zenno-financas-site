<?php
session_start();

// Configurações do Supabase
$supabaseUrl = 'https://kdsuvlaeepwjzqnfvxxr.supabase.co';
$supabaseKey =  'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Imtkc3V2bGFlZXB3anpxbmZ2eHhyIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NTYxNTMwMTIsImV4cCI6MjA3MTcyOTAxMn0.iuOiaoqm3BhPyEMs6mtn2KlA2CIuYdnkcfmc36_Z8t8';
$tabela = 'admins';

// Recebe dados do formulário
$cpf = preg_replace('/\D/', '', $_POST['cpf']); // REMOVE . e -
$senha = trim($_POST['senha']);

// Monta query para buscar o administrador com CPF igual ao informado
$url = $supabaseUrl."/rest/v1/$tabela?cpf=eq.$cpf";

// cURL para consultar a tabela
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "apikey: $supabaseKey",
    "Authorization: Bearer $supabaseKey",
    "Content-Type: application/json"
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

// Decodifica JSON
$data = json_decode($response, true);

// Valida login
if(!empty($data)) {

    if (trim($data[0]['senha']) === $senha) {
        $_SESSION['adm_logado'] = $data[0]['cpf'];
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
