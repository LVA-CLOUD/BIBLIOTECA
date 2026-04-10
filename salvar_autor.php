<?php
include_once("conexao.php");

$nome = $_POST['nome'];
$nacionalidade = $_POST['nacionalidade'];

$sql = "INSERT INTO autores (nome, nacionalidade)
        VALUES ('$nome', '$nacionalidade')";

$conn->query($sql);

header("Location: cadastro.php");
?>