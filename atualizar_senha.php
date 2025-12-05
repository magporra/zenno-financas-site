<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// CONFIGURAÇÃO SUPABASE
$SUPABASE_URL = "https://SEU_PROJETO.supabase.co";
$SUPABASE_KEY = "SERVICE_ROLE_KEY_AQUI";

$token = $_POST['token'] ?? '';
$senha = $_POST['senha'] ?? '';

if (empty($token) || empty($senha)) {
    die("<h3>Dados inválidos.</h3>");
}

// 1. Buscar admin pelo token
$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => "$SUPABASE_URL/rest/v1/admins?reset_token=eq.$token",
    CURLOPT_HTTPHEADER => [
        "apikey: $SUPABASE_KEY",
        "Authorization: Bearer $SUPABASE_KEY"
    ],
    CURLOPT_RETURNTRANSFER => true
]);

$response = curl_exec($curl);
$data = json_decode($response, true);

if (empty($data)) {
    die("<h3>Token inválido.</h3>");
}

$admin = $data[0];

// 2. Verificar expiração
if (strtotime($admin['token_expira']) < time()) {
    die("<h3>Token expirado. Solicite outro.</h3>");
}

$admin_id = $admin['id'];

// 3. Criptografar senha (melhor prática)
$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

// 4. Atualizar senha + limpar token
$body = json_encode([
    "senha" => $senhaHash,
    "reset_token" => null,
    "token_expira" => null
]);

$curl2 = curl_init();
curl_setopt_array($curl2, [
    CURLOPT_URL => "$SUPABASE_URL/rest/v1/admins?id=eq.$admin_id",
    CURLOPT_CUSTOMREQUEST => "PATCH",
    CURLOPT_POSTFIELDS => $body,
    CURLOPT_HTTPHEADER => [
        "apikey: $SUPABASE_KEY",
        "Authorization: Bearer $SUPABASE_KEY",
        "Content-Type: application/json"
    ],
    CURLOPT_RETURNTRANSFER => true
]);

curl_exec($curl2);

echo "<h3>Senha alterada com sucesso!</h3><a href='login-adm.php'>Voltar ao Login</a>";
?>
