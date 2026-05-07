<?php
// Verifica se a sessão já não está ativa antes de iniciar
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once("conexao.php");
include("verifica_login.php");

$id_regi = $_SESSION['id_usuario'] ?? null;

// Tenta pegar o ID do POST, se não existir, tenta do GET
$id_livro = filter_input(INPUT_POST, 'id_livro', FILTER_VALIDATE_INT) ?? filter_input(INPUT_GET, 'id_livro', FILTER_VALIDATE_INT);

if (!$id_livro) {
    echo "ID do livro inválido ou não fornecido.";
    exit;
}

if (!$id_regi) {
    echo "Usuário não autenticado.";
    exit;
}


$stmt = $conn->prepare("DELETE FROM emprestimos WHERE id_livro = ? AND id_regi = ?");

if (!$stmt) {
    echo "Erro na preparação da query: " . $conn->error;
    exit;
}

$stmt->bind_param("ii", $id_livro, $id_regi);

if ($stmt->execute()) {
    // Verifica se alguma linha foi realmente deletada
    if ($stmt->affected_rows > 0) {
        header("Location: ../pages/meus_emprestimos.php?status=devolvido");
        exit;
    } else {
        echo "Nenhum empréstimo ativo encontrado para este livro.";
    }
} else {
    echo "Erro ao processar devolução: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>