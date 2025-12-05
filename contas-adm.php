<!doctype html>
<html lang="pt-br">
<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ZENNO - Contas ADM</title>
  <link rel="icon" type="image/x-icon" href="favicon.ico">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="zenno-bg">

  <!-- Sidebar -->
  <div class="sidebar d-flex flex-column p-3">
    <h3 class="text-white">Menu</h3>
    <ul class="nav flex-column">
      <li class="nav-item"><a href="cadastro-adm.php" class="nav-link">Cadastro</a></li>
      <li class="nav-item"><a href="contas-adm.php" class="nav-link">Contas</a></li>
      <li class="nav-item"><a href="faq.php" class="nav-link">FAQ</a></li>
      <li class="nav-item"><a href="tela-adm.php" class="nav-link text-danger">Voltar</a></li>
    </ul>
  </div>

  <!-- Conteúdo principal -->
  <div class="main-content">

      <div class="topbar">
        CONTAS
      </div>

      <h2 class="mb-4 mt-4">Lista de Administradores</h2>

      <table class="zenno-table">
        <thead>
          <tr>
            <th>Nome</th>
            <th>CPF</th>
          </tr>
        </thead>

        <tbody id="lista-adms">
          <tr><td colspan="2" class="text-center">Carregando...</td></tr>
        </tbody>

      </table>

  </div>

  <script src="js/contas-adm.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
