<?php
include_once("conexao.php");

$titulo = $_POST['titulo'];
$ano = $_POST['ano'];
$id_autor = $_POST['id_autor'];

$stmt = $conn->prepare("INSERT INTO livros (titulo, ano_publicacao, id_autor) VALUES (?, ?, ?)");
$stmt->bind_param("ssi", $titulo, $ano, $id_autor);
$stmt->execute();

// para se manter na pagina de cadastro
header("Location: ../pages/cadastro.php");
?>