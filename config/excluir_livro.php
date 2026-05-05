<?php
include("verifica_funcionario.php");
include_once("conexao.php");

if (isset($_POST['id_livro'])) {
    $id = $_POST['id_livro'];

    $stmt = $conn->prepare("DELETE FROM livros WHERE id_livro = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "sucesso"; // O JavaScript lerá isso
    } else {
        echo "Erro ao deletar: " . $conn->error;
    }
    $stmt->close();
}
?>