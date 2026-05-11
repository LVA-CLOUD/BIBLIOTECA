<?php
include_once("conexao.php");

if (isset($_POST['id_livro']) && isset($_POST['destaque'])) {
    $id = intval($_POST['id_livro']);
    $status = intval($_POST['destaque']);

    // Atualiza apenas o campo destaque do livro específico
    $sql = "UPDATE livros SET destaque = ? WHERE id_livro = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $status, $id);

    if ($stmt->execute()) {
        echo "Sucesso";
    } else {
        echo "Erro";
    }
    $stmt->close();
}
$conn->close();
?>