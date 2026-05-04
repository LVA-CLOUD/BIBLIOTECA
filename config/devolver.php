<?php
session_start();
include_once("conexao.php");
include("verifica_login.php");

$id_regi = $_SESSION['id_usuario'] ?? null;

// Valida o ID vindo do POST
$id_livro = filter_input(INPUT_POST, 'id_livro', FILTER_VALIDATE_INT);

if ($id_livro === false || $id_livro === null) {
    echo "ID do livro inválido.";
    exit;
}

if (!$id_regi) {
    echo "Usuário não autenticado.";
    exit;
}

// Prepara a query
$stmt = $conn->prepare("DELETE FROM emprestimos WHERE id_livro = ? AND id_regi = ?");

if (!$stmt) {
    echo "Erro na preparação da query.";
    exit;
}

$stmt->bind_param("ii", $id_livro, $id_regi);

// Executa
if ($stmt->execute()) {
    header("Location: ../pages/meus_emprestimos.php?status=devolvido");
    exit;
} else {
    echo "Erro ao processar devolução.";
}

$stmt->close();
$conn->close();
?>