<?php
include_once("conexao.php");

$titulo = $_POST['titulo'];
$ano = $_POST['ano'];
$id_autor = $_POST['id_autor'];

$stmt = $conn->prepare("INSERT INTO livros (titulo, ano_publicacao, id_autor) VALUES (?, ?, ?)");
$stmt->bind_param("ssi", $titulo, $ano, $id_autor);

$result = $stmt->execute(); // executa só uma vez

// para se manter na pagina de cadastro
if ($result) {
    header("Location: ../pages/cadastro.php?status=success&msg=Livro cadastrado com sucesso!");
} else {
    header("Location: ../pages/cadastro.php?status=error&msg=Erro ao cadastrar livro.");
}
exit();
?>