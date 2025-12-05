<?php
session_start();

// =============================
// CONFIGURAÇÕES DO SUPABASE
// =============================
$supabaseUrl = 'https://kdsuvlaeepwjzqnfvxxr.supabase.co';
$supabaseKey =  'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Imtkc3V2bGFlZXB3anpxbmZ2eHhyIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NTYxNTMwMTIsImV4cCI6MjA3MTcyOTAxMn0.iuOiaoqm3BhPyEMs6mtn2KlA2CIuYdnkcfmc36_Z8t8';


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: fale-conosco.php");
    exit();
}

$nome     = trim($_POST['nome'] ?? '');
$email    = trim($_POST['email'] ?? '');
$assunto  = trim($_POST['assunto'] ?? '');
$mensagem = trim($_POST['mensagem'] ?? '');

if (empty($nome) || empty($email) || empty($mensagem)) {
    $_SESSION['erro_faleconosco'] = "Por favor, preencha todos os campos obrigatórios!";
    header("Location: fale-conosco.php");
    exit();
}

$endpoint = $supabaseUrl . "/rest/v1/fale_conosco";

$payload = json_encode([
    "nome"     => $nome,
    "email"    => $email,
    "assunto"  => $assunto,
    "mensagem" => $mensagem,
    "status"   => "Pendente"   // mantenha o mesmo casing que você usa no admin/faq.php
]);

$ch = curl_init($endpoint);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "apikey: $supabaseKey",
    "Authorization: Bearer $supabaseKey",
    "Content-Type: application/json",
    "Prefer: return=minimal"
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlErro = curl_error($ch);
curl_close($ch);

if ($httpCode === 201 || $httpCode === 204) {
    $_SESSION['sucesso_faleconosco'] = "Mensagem enviada com sucesso!";
} else {
    // não exibir resposta bruta em produção por segurança — logue em arquivo se quiser
    $_SESSION['erro_faleconosco'] = "Erro ao enviar sua mensagem! (code: $httpCode)";
    // opcional: gravar erro completo em log para depuração
    error_log("FaleConosco ERRO: HTTP $httpCode | CURL: $curlErro | RESPOSTA: $response");
}

header("Location: fale-conosco.php");
exit();
