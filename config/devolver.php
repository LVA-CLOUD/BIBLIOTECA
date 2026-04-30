<?php
session_start();
include_once("conexao.php");

// Verifica se o usuário está logado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login.php");
    exit;
}

$id_regi = $_SESSION['id_usuario'];
$id_livro = filter_input(INPUT_POST, 'id_livro', FILTER_VALIDATE_INT);

if ($id_livro) {
    $stmt = $conn->prepare("DELETE FROM emprestimos WHERE id_livro = ? AND id_regi = ?");
    $stmt->bind_param("ii", $id_livro, $id_regi);
    
    if ($stmt->execute()) {
        header("Location: ../pages/meus_emprestimos.php?status=devolvido");
    } else {
        echo "Erro ao processar devolução.";
    }
} else {
    echo "ID do livro inválido.";
}
?>