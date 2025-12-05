<?php include 'header.php'; ?>

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow p-4" style="width: 100%; max-width: 400px;">
        <h3 class="text-center mb-4">Recuperar Senha</h3>

        <form method="POST" action="enviar_reset.php">
            <div class="mb-3">
                <label for="email" class="form-label">Digite seu Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Enviar link de recuperação</button>
            </div>
        </form>

        <div class="mt-3 text-center">
            <a href="login-adm.php">Voltar ao login</a>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
