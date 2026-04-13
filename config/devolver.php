<?php
session_start();
include_once("./config/conexao.php");

$id_regi = $_SESSION['id_regi'];
$id_livro = (int) $_GET['id_livro'];

$sql = "DELETE FROM emprestimos 
WHERE id_livro = $id_livro AND id_regi = $id_regi";

if ($conn->query($sql)) {
    header("Location: meus_emprestimos.php");
} else {
    echo "Erro ao devolver";
}