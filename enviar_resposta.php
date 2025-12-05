<?php
session_start();

// ===============================
// CONFIGURAÇÕES DO SUPABASE
// ===============================
$supabaseUrl = 'https://kdsuvlaeepwjzqnfvxxr.supabase.co';
$supabaseKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Imtkc3V2bGFlZXB3anpxbmZ2eHhyIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NTYxNTMwMTIsImV4cCI6MjA3MTcyOTAxMn0.iuOiaoqm3BhPyEMs6mtn2KlA2CIuYdnkcfmc36_Z8t8';

// ===============================
// RECEBE DADOS DO FORMULÁRIO
// ===============================
$id        = $_POST['id'] ?? null;
$nome      = $_POST['nome'] ?? null;
$email     = $_POST['email'] ?? null;
$assunto   = $_POST['assunto'] ?? "Resposta - Zenno";
$resposta  = $_POST['resposta'] ?? null;

if (!$id || !$email || !$resposta) {
    $_SESSION['erro'] = "Dados incompletos para envio da resposta.";
    header("Location: faq.php");
    exit;
}

// ===============================
// ENVIO DO EMAIL COM PHPMailer
// ===============================
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'financaszenno@gmail.com';
    $mail->Password   = 'nsaxpieggplshjcp';
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    $mail->setFrom('financaszenno@gmail.com', 'Equipe Zenno');
    $mail->addAddress($email, $nome);

    $mail->isHTML(true);
    $mail->Subject = "Resposta sobre: $assunto";
    $mail->Body    = "
        <p>Olá, <strong>$nome</strong>!</p>
        <p>$resposta</p>
        <br>
        <p>Equipe Zenno</p>
    ";

    $mail->send();

} catch (Exception $e) {
    $_SESSION['erro'] = "Falha ao enviar o email.";
    header("Location: faq.php");
    exit;
}

// ===============================
// ATUALIZA NO SUPABASE (STATUS + RESPOSTA)
// ===============================
$endpoint = $supabaseUrl . "/rest/v1/fale_conosco?id=eq.$id";



$body = json_encode([
    "resposta_admin" => $resposta,
    "status" => "respondido"
]);

$ch = curl_init($endpoint);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "apikey: $supabaseKey",
    "Authorization: Bearer $supabaseKey",
    "Content-Type: application/json",
    "Prefer: return=minimal"
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_exec($ch);

curl_close($ch);

// ===============================
// FINALIZA
// ===============================
$_SESSION['sucesso'] = "Resposta enviada com sucesso!";
header("Location: faq.php");
exit;
?>
