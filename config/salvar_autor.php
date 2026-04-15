<?php
include_once("conexao.php");

$nome = $_POST['nome'];
$nacionalidade = $_POST['nacionalidade'];

$stmt = $conn->prepare("INSERT INTO autores (nome, nacionalidade) VALUES (?, ?)");
$stmt->bind_param("ssi", $titulo, $ano, $id_autor);
$stmt->execute();

$conn->query($sql);

header("Location: cadastro.php");
?>