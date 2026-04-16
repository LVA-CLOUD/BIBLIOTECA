<?php
include_once("conexao.php");

$nome = $_POST['nome'];
$nacionalidade = $_POST['nacionalidade'];

$stmt = $conn->prepare("INSERT INTO autores (nome, nacionalidade) VALUES (?, ?)");
$stmt->bind_param("ss", $nome, $nacionalidade);
$stmt->execute();

// para se manter na pgina de cadastro
if ($stmt->execute()) {
    header("Location: ../pages/cadastro.php?status=success&msg=Autor cadastrado com sucesso!");
} else {
    header("Location: ../pages/cadastro.php?status=error&msg=Erro ao cadastrar autor.");
}
exit();
?>