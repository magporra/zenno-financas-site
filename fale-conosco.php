<?php include 'header.php'; ?>

<div class="vh-100">
<?php
session_start();

if(isset($_SESSION['sucesso_faleconosco'])) {
    echo '
    <div class="alert alert-success text-center fade show" role="alert">
        ✔ Sua mensagem foi enviada com sucesso! Em breve entraremos em contato.
    </div>';
    unset($_SESSION['sucesso_faleconosco']);
}

if(isset($_SESSION['erro_faleconosco'])) {
    echo '
    <div class="alert alert-danger text-center fade show" role="alert">
        ⚠ Ocorreu um erro ao enviar sua mensagem. Tente novamente.
    </div>';
    unset($_SESSION['erro_faleconosco']);
}
?>

<p class="text-muted text-center mt-3">Preencha as informações abaixo para entrar em contato conosco!</p>

<form method="POST" action="processa_faleconosco.php" class="mx-auto mt-3" style="max-width: 560px;">
    <div class="mb-3">
        <label class="form-label">Nome:</label>
        <input type="text" name="nome" class="form-control" placeholder="Seu nome" required>
    </div>
    <div class="mb-3">
        <label class="form-label">E-mail:</label>
        <input type="email" name="email" class="form-control" placeholder="seuemail@exemplo.com" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Assunto:</label>
        <input type="text" name="assunto" class="form-control" placeholder="Assunto da mensagem">
    </div>
    <div class="mb-3">
        <label class="form-label">Escreva sua mensagem abaixo:</label>
        <textarea name="mensagem" class="form-control" rows="5" placeholder="Digite sua mensagem aqui..." required></textarea>
    </div>
    <div class="d-grid">
        <button type="submit" class="btn btn-primary">Enviar</button>
    </div>
</form>
</div>

<?php include 'footer.php'; ?>
