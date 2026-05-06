<?php
include("verifica_funcionario.php");
include_once("conexao.php");

if (isset($_POST['id_livro'])) {
    $id = $_POST['id_livro'];

    $stmt = $conn->prepare("DELETE FROM livros WHERE id_livro = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "sucesso";
    } else {
        // Verifica se o erro é de restrição de chave estrangeira
        if ($conn->errno == 1451) {
            echo "Não é possível excluir: Este livro possui registros de empréstimos ativos.";
        } else {
            echo "Erro no banco de dados: " . $conn->error;
        }
    }
    $stmt->close();
}
$conn->close();
?>