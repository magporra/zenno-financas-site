<?php

session_start();
include 'header.php';
?>

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow p-4" style="width: 100%; max-width: 400px;">
      <h3 class="text-center mb-4">Login</h3>

      <!-- Mensagem de erro -->
      <?php
      if(isset($_SESSION['erro_login'])) {
          echo '<div class="alert alert-danger text-center">' . $_SESSION['erro_login'] . '</div>';
          unset($_SESSION['erro_login']); // remove a mensagem após exibir
      }
      ?>

      <!-- Formulário -->
      <form method="POST" action="processa_login.php">
        <div class="mb-3">
          <label for="cpf" class="form-label">CPF</label>
          <input type="text" class="form-control" id="cpf" name="cpf" placeholder="000.000.000-00" required>
        </div>

        <div class="mb-3">
          <label for="senha" class="form-label">Senha</label>
          <input type="password" class="form-control" id="senha" name="senha" placeholder="Digite sua senha" required>
        </div>

        <div class="d-grid">
          <button type="submit" class="btn btn-primary">Entrar</button>
        </div>
      </form>

      <div class="mt-3 text-center">
        <a href="#">Esqueceu a senha?</a>
      </div>
    </div>
</div>

<?php include 'footer.php'; ?>
