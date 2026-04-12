<?php
include_once("conexao.php");

$titulo = $_POST['titulo'];
$ano = $_POST['ano'];
$id_autor = $_POST['id_autor'];

$sql = "INSERT INTO livros (titulo, ano_publicacao, id_autor)
        VALUES ('$titulo', '$ano', '$id_autor')";

$conn->query($sql);

header("Location: cadastro.php");
?>