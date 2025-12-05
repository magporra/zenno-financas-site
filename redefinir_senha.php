<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// CONFIG SUPABASE
$SUPABASE_URL = 'https://kdsuvlaeepwjzqnfvxxr.supabase.co';
$SUPABASE_KEY = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Imtkc3V2bGFlZXB3anpxbmZ2eHhyIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NTYxNTMwMTIsImV4cCI6MjA3MTcyOTAxMn0.iuOiaoqm3BhPyEMs6mtn2KlA2CIuYdnkcfmc36_Z8t8';

// 1) RECEBER TOKEN
$token = $_GET['token'] ?? null;

if (!$token) {
    die("Token inválido.");
}

// 2) CONSULTAR USUÁRIO COM ESSE TOKEN
$url = "$SUPABASE_URL/rest/v1/admins?reset_token=eq.$token&select=*";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "apikey: $SUPABASE_KEY",
    "Authorization: Bearer $SUPABASE_KEY",
    "Content-Type: application/json"
]);

$response = curl_exec($ch);
$userData = json_decode($response, true);

if (empty($userData)) {
    die("Token inválido ou expirado.");
}

$user = $userData[0];
$user_id = $user["id"];

// 3) VERIFICAR EXPIRAÇÃO
if (strtotime($user["token_expira"]) < time()) {
    die("Token expirado. Solicite uma nova recuperação de senha.");
}

// 4) SE O FORM FOR ENVIADO, ATUALIZA A SENHA
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $senha1 = $_POST["senha"] ?? "";
    $senha2 = $_POST["confirmar"] ?? "";

    if ($senha1 !== $senha2) {
        echo "<p style='color:red'>As senhas não coincidem.</p>";
    } else {
        $hash = password_hash($senha1, PASSWORD_BCRYPT);

        // Atualizar senha e apagar token
        $updateUrl = "$SUPABASE_URL/rest/v1/admins?id=eq.$user_id";

        $body = json_encode([
            "senha" => $hash,
            "reset_token" => null,
            "token_expira" => null
        ]);

        $ch2 = curl_init($updateUrl);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, "PATCH");
        curl_setopt($ch2, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch2, CURLOPT_HTTPHEADER, [
            "apikey: $SUPABASE_KEY",
            "Authorization: Bearer $SUPABASE_KEY",
            "Content-Type: application/json"
        ]);

        curl_exec($ch2);

        curl_exec($ch2);

        echo '
        <!DOCTYPE html>
        <html lang="pt-br">
        <head>
            <meta charset="UTF-8">
            <title>Senha Redefinida</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
            <style>
                body {
                    background-color: #e0e0e0;
                    height: 100vh;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }
                .box-sucesso {
                    background: #fff;
                    padding: 40px;
                    border-radius: 12px;
                    text-align: center;
                    box-shadow: 0 0 15px rgba(0,0,0,0.1);
                    max-width: 400px;
                    width: 100%;
                }
            </style>
        </head>
        <body>
        
            <div class="box-sucesso">
                <h3 class="mb-3 text-success">✅ Senha redefinida com sucesso!</h3>
                <p>Agora você já pode acessar sua conta normalmente.</p>
                <a href="login-adm.php" class="btn btn-primary mt-3">Ir para o login</a>
            </div>
        
        </body>
        </html>
        ';
        exit;
        
    }
}
?>

<!-- FORMULÁRIO HTML -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Redefinir Senha</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow p-4" style="width: 100%; max-width: 400px;">
        <h3 class="text-center mb-4">Nova Senha</h3>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Nova Senha</label>
                <input type="password" class="form-control" name="senha" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Confirmar Senha</label>
                <input type="password" class="form-control" name="confirmar" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Salvar Nova Senha</button>
        </form>
    </div>
</div>

</body>
</html>
