<?php

session_start();
?>

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow p-4" style="width: 100%; max-width: 500px;">
      <h3 class="text-center mb-4">Cadastro de Administrador</h3>

      <!-- Mensagem de aviso -->
      <?php
      if(isset($_SESSION['msg_cadastro'])) {
          echo '<div class="alert alert-info text-center">' . $_SESSION['msg_cadastro'] . '</div>';
          unset($_SESSION['msg_cadastro']); // remove a mensagem após exibir
      }
      ?>

<?php
if(isset($_SESSION['sucesso_cadastro'])) {
    echo '<div class="alert alert-success text-center">' . $_SESSION['sucesso_cadastro'] . '</div>';
    unset($_SESSION['sucesso_cadastro']);
}

if(isset($_SESSION['erro_cadastro'])) {
    echo '<div class="alert alert-danger text-center">' . $_SESSION['erro_cadastro'] . '</div>';
    unset($_SESSION['erro_cadastro']);
}
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
    
    <form method="POST" action="processa_cadastro.php">
        <div class="mb-3">
          <label for="nome" class="form-label">Nome completo</label>
          <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite seu nome" required>
        </div>

        <div class="mb-3">
          <label for="cpf" class="form-label">CPF</label>
          <input type="text" class="form-control" id="cpf" name="cpf" placeholder="000.000.000-00" required>
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">E-mail</label>
          <input type="email" class="form-control" id="email" name="email" placeholder="seu@email.com" required>
        </div>

        <div class="mb-3">
          <label for="senha" class="form-label">Senha</label>
          <input type="password" class="form-control" id="senha" name="senha" placeholder="Digite uma senha" required>
        </div>

        <div class="d-grid">
          <button type="submit" class="btn btn-success">Cadastrar</button>
        </div>
      </form>

      <div class="mt-3 text-center">
        <a href="login-adm.php">Já tem conta? Faça login</a>
      </div>
    </div>
</div>

  <!-- Bootstrap + Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="js/charts.js"></script>
</body>
</html>
