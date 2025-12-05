<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$SUPABASE_URL = "https://kdsuvlaeepwjzqnfvxxr.supabase.co";
$SUPABASE_KEY = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Imtkc3V2bGFlZXB3anpxbmZ2eHhyIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NTYxNTMwMTIsImV4cCI6MjA3MTcyOTAxMn0.iuOiaoqm3BhPyEMs6mtn2KlA2CIuYdnkcfmc36_Z8t8";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit(json_encode(["status" => "erro", "mensagem" => "Método inválido"]));
}

$email = trim($_POST['email'] ?? '');
if ($email === '') {
    exit(json_encode(["status" => "erro", "mensagem" => "Informe um e-mail"]));
}

// 🔥 USAR ILIKE para garantir que o Supabase ENCONTRE
$encodedEmail = urlencode($email);
$url = "$SUPABASE_URL/rest/v1/admins?email=ilike.$encodedEmail&select=*";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "apikey: $SUPABASE_KEY",
    "Authorization: Bearer $SUPABASE_KEY",
    "Content-Type: application/json",
    "Accept: application/json"
]);

$response = curl_exec($ch);
$http = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if ($response === false) {
    exit(json_encode(["status" => "erro", "mensagem" => curl_error($ch)]));
}

$adminData = json_decode($response, true);

// SE NÃO ENCONTROU O EMAIL
if (empty($adminData)) {
    exit(json_encode(["status" => "erro", "mensagem" => "Este e-mail não existe no sistema."]));
}

$admin = $adminData[0];
$admin_id = $admin["id"];

// ==========================
// GERAR TOKEN
$token = bin2hex(random_bytes(32));
$expires = date("c", strtotime("+30 minutes"));

$patchUrl = "$SUPABASE_URL/rest/v1/admins?id=eq.$admin_id";
$patchBody = json_encode([
    "reset_token" => $token,
    "token_expira" => $expires
]);

$ch2 = curl_init($patchUrl);
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, "PATCH");
curl_setopt($ch2, CURLOPT_POSTFIELDS, $patchBody);
curl_setopt($ch2, CURLOPT_HTTPHEADER, [
    "apikey: $SUPABASE_KEY",
    "Authorization: Bearer $SUPABASE_KEY",
    "Content-Type: application/json",
    "Accept: application/json"
]);

$resp2 = curl_exec($ch2);

$RESET_LINK = "http://tcc3edsmodetecgr5.hospedagemdesites.ws/sitezera/redefinir_senha.php?token=$token";

// ==========================
// ENVIAR EMAIL COM PHPMailer
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;

$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->Host = 'smtp-relay.brevo.com';
$mail->SMTPAuth = true;
$mail->Username = '9d2c68001@smtp-brevo.com';
$mail->Password = 'daQyMPBZWb10hOwX';
$mail->Port = 587;

$mail->setFrom('financaszenno@gmail.com', 'Suporte');
$mail->addAddress($email);
$mail->Subject = "Recuperação de Senha";
$mail->isHTML(true);
$mail->Body = "
    <p>Olá!</p>
    <p>Clique abaixo para redefinir a senha:</p>
    <p><a href='$RESET_LINK'>$RESET_LINK</a></p>
";

$mail->send();


header("Location: esqueci-senha.php");
exit();
