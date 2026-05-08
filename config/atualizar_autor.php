<?php
include("verifica_funcionario.php");
include_once("conexao.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_autor = $_POST['id_autor'];
    $nome = $_POST['nome'];
    $nacionalidade = $_POST['nacionalidade'];
    $action = $_POST['action'];

    if ($action === 'update') {
        $sql = "UPDATE autores SET nome = ?, nacionalidade = ? WHERE id_autor = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $nome, $nacionalidade, $id_autor);
        
        if ($stmt->execute()) {
            header("Location: ../pages/editFunci.php?status=success_update");
        } else {
            echo "Erro ao atualizar: " . $conn->error;
        }
    } 
    elseif ($action === 'delete') {
        // Cuidado: Só deleta se não houver livros vinculados (ou use cascata no banco)
        $sql = "DELETE FROM autores WHERE id_autor = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_autor);
        
        try {
            if ($stmt->execute()) {
                header("Location: ../pages/editFunci.php?status=success_delete");
            }
        } catch (Exception $e) {
            echo "Erro: Verifique se este autor possui livros cadastrados antes de excluir.";
        }
    }
}
?>