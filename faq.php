<?php
session_start();

$supabaseUrl = 'https://kdsuvlaeepwjzqnfvxxr.supabase.co';
$supabaseKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Imtkc3V2bGFlZXB3anpxbmZ2eHhyIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NTYxNTMwMTIsImV4cCI6MjA3MTcyOTAxMn0.iuOiaoqm3BhPyEMs6mtn2KlA2CIuYdnkcfmc36_Z8t8';

$endpoint = $supabaseUrl . "/rest/v1/fale_conosco?status=eq.Pendente&select=*";

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
  <title>ZENNO - FAQ / Mensagens</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">

  <style>
      table {
          width: 100%;
          border-collapse: collapse;
          margin-top: 20px;
          background: white;
      }
      th, td {
          padding: 10px;
          border: 1px solid #ddd;
          text-align: left;
      }
      th {
          background: #f2f2f2;
      }
  </style>
</head>
<body class="zenno-bg">

<?php include 'side-bar.php' ?>

<!-- CONTEÚDO AJUSTADO -->
<div class="main-content">

    <h2 class="text-center mb-4">Mensagens recebidas</h2>

    <?php if (!$mensagens || count($mensagens) === 0): ?>
        <div class="alert alert-warning text-center">
            Nenhuma mensagem encontrada.
        </div>
    <?php else: ?>

    <table class="table table-bordered table-striped">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Assunto</th>
            <th>Mensagem</th>
            <th>Status</th>
            <th>Ação</th>
        </tr>

        <?php foreach ($mensagens as $m): ?>
            <tr>
                <td><?= $m['id'] ?></td>
                <td><?= htmlspecialchars($m['nome']) ?></td>
                <td><?= htmlspecialchars($m['email']) ?></td>
                <td><?= htmlspecialchars($m['assunto']) ?></td>
                <td><?= nl2br(htmlspecialchars($m['mensagem'])) ?></td>
                <td><?= htmlspecialchars($m['status']) ?></td>
                <td>
                    <button class="btn btn-success btn-sm"
                            onclick="abrirResposta(<?= $m['id'] ?>)">
                        Responder
                    </button>
                </td>
            </tr>

            <tr id="resposta-<?= $m['id'] ?>" style="display:none;">
                <td colspan="7">
                    <form method="POST" action="enviar_resposta.php" class="p-3 border rounded bg-light">

                        <input type="hidden" name="id" value="<?= $m['id'] ?>">
                        <input type="hidden" name="email" value="<?= $m['email'] ?>">
                        <input type="hidden" name="nome" value="<?= $m['nome'] ?>">
                        <input type="hidden" name="assunto" value="<?= $m['assunto'] ?>">

                        <label><strong>Responder para <?= $m['nome'] ?>:</strong></label>
                        <textarea name="resposta" class="form-control mb-2" rows="4" required></textarea>

                        <button class="btn btn-primary">Enviar Resposta</button>
                        <button type="button" class="btn btn-secondary"
                                onclick="fecharResposta(<?= $m['id'] ?>)">Cancelar</button>
                    </form>
                </td>
            </tr>

        <?php endforeach; ?>

    </table>

    <?php endif; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
function abrirResposta(id) {
    document.getElementById("resposta-" + id).style.display = "table-row";
}
function fecharResposta(id) {
    document.getElementById("resposta-" + id).style.display = "none";
}
</script>

</body>
</html>
