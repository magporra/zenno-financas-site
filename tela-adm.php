<?php
session_start();
if(isset($_SESSION['erro_login'])) {
    echo '<div class="alert alert-danger text-center">' . $_SESSION['erro_login'] . '</div>';
    unset($_SESSION['erro_login']);
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

<!-- Sidebar -->
<div class="sidebaradm sidebar d-flex flex-column p-3">
  <h3 class="text-white">Menu</h3>
  <ul class="nav flex-column">
    <li class="nav-item"><a href="cadastro-adm.php" class="nav-link">Cadastro</a></li>
    <li class="nav-item"><a href="contas-adm.php" class="nav-link">Contas</a></li>
    <li class="nav-item"><a href="faq.php" class="nav-link">FAQ</a></li>
    <li class="nav-item"><a href="index.php" class="nav-link text-danger">Sair</a></li>
  </ul>
</div>

<!-- CONTEÚDO PRINCIPAL (tudo aqui dentro!) -->
<div class="main-content">

  <!-- Nome do Admin -->
  <span class="text-white fw-bold ms-2">
      <?php echo isset($_SESSION['nome_adm']) ? $_SESSION['nome_adm'] : ''; ?>
  </span>

  <!-- Gráfico -->
  <div class="card-block mt-4">
    <h5>Usuários Cadastrados Por Semana</h5>
    <canvas id="barChart"></canvas>
  </div>

</div> <!-- fim do main-content -->

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="js/grafico-usuarios.js"></script>

</body>
</html>
