<?php
include_once("verifica_funcionario.php");
include_once("conexao.php");

$id = $_GET['id'];
$acao = $_GET['acao']; // 'aprovado' ou 'negado'

$sql = "UPDATE emprestimos SET status = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $acao, $id);
$stmt->execute();

header("Location: ../pages/emprestimo_funcionario.php");
?>