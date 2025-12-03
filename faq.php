<?php
session_start();

// Configurações do Supabase
$supabaseUrl = 'https://SEU_PROJETO.supabase.co';
$supabaseKey = 'SUA_CHAVE_API';

$endpoint = $supabaseUrl . '/rest/v1/fale-conosco?select=*';

// Faz a requisição GET
$ch = curl_init($endpoint);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'apikey: ' . $supabaseKey,
    'Authorization: Bearer ' . $supabaseKey,
    'Content-Type: application/json'
));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
curl_close($ch);

$mensagens = json_decode($response, true);
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ZENNO - Introdução</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="zenno-bg">
    
    <?php include 'side-bar.php'?>

<?php


// Configurações do Supabase
$supabaseUrl = 'https://SEU_PROJETO.supabase.co';
$supabaseKey = 'SUA_CHAVE_API';

$endpoint = $supabaseUrl . '/rest/v1/fale-conosco?select=*';

// Faz a requisição GET
$ch = curl_init($endpoint);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'apikey: ' . $supabaseKey,
    'Authorization: Bearer ' . $supabaseKey,
    'Content-Type: application/json'
));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
curl_close($ch);

$mensagens = json_decode($response, true);
?>

<div class="container">
    <h1 class="titulo">📩 Mensagens recebidas – Fale Conosco</h1>

    <?php if (!$mensagens || count($mensagens) === 0): ?>
        <div class="msg-vazia">Nenhuma mensagem recebida ainda.</div>
    <?php else: ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Assunto</th>
                <th>Mensagem</th>
                <th>Data</th>
            </tr>

            <?php foreach ($mensagens as $m): ?>
                <tr>
                    <td><?= $m['id'] ?></td>
                    <td><?= htmlspecialchars($m['nome']) ?></td>
                    <td><?= htmlspecialchars($m['email']) ?></td>
                    <td><?= htmlspecialchars($m['assunto']) ?></td>
                    <td><?= nl2br(htmlspecialchars($m['mensagem'])) ?></td>
                    <td><?= $m['created_at'] ?? '' ?></td>
                </tr>
            <?php endforeach; ?>

        </table>
    <?php endif; ?>
</div>
  <!-- Bootstrap + Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="js/charts.js"></script>
</body>
</html>





