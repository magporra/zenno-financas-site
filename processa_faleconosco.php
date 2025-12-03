<?php
session_start();
require_once 'conexao.php'; // Conecta ao banco

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Recebe os dados do formulário e evita SQL Injection
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $assunto = trim($_POST['assunto'] ?? '');
    $mensagem = trim($_POST['mensagem'] ?? '');

    // Validação simples: campos obrigatórios
    if (empty($nome) || empty($email) || empty($mensagem)) {
        $_SESSION['erro_faleconosco'] = "Por favor, preencha todos os campos obrigatórios!";
        header("Location: faleconosco.php");
        exit();
    }

    // Insere os dados no banco
    $sql = "INSERT INTO mensagens (nome, email, assunto, mensagem) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nome, $email, $assunto, $mensagem);

    if ($stmt->execute()) {
        $_SESSION['sucesso_faleconosco'] = "Mensagem enviada com sucesso!";
    } else {
        $_SESSION['erro_faleconosco'] = "Ocorreu um erro ao enviar sua mensagem. Tente novamente!";
    }

    $stmt->close();
    $conn->close();

    // Redireciona de volta para a página do formulário
    header("Location: faleconosco.php");
    exit();

} else {
    // Caso acessem o arquivo sem enviar o formulário
    header("Location: faleconosco.php");
    exit();
}
?>
