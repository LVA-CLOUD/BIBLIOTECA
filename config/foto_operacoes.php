<?php
include("verifica_funcionario.php");
include_once("conexao.php");

$operacao = $_GET['op'] ?? null;
$id_foto = $_GET['id_foto'] ?? null;
$id_livro = $_GET['id_livro'] ?? null;

if (!$operacao || !$id_foto || !$id_livro) {
    die("Erro: Dados insuficientes.");
}

if ($operacao === 'del') {
    $sqlBusca = "SELECT caminho FROM livros_imagens WHERE id_livro_img = ?";
    $stmtBusca = $conn->prepare($sqlBusca);
    $stmtBusca->bind_param("i", $id_foto);
    $stmtBusca->execute();
    $resultado = $stmtBusca->get_result()->fetch_assoc();

    if ($resultado) {
        // AJUSTE: O caminho já vem como 'assets/img/...' do banco
        $caminho_arquivo = "../" . $resultado['caminho'];
        
        if (file_exists($caminho_arquivo)) {
            unlink($caminho_arquivo);
        }

        $sqlDel = "DELETE FROM livros_imagens WHERE id_livro_img = ?";
        $stmtDel = $conn->prepare($sqlDel);
        $stmtDel->bind_param("i", $id_foto);
        
        if ($stmtDel->execute()) {
            header("Location: ../pages/editLivro.php?id=$id_livro&status=foto_excluida");
        }
    }
    exit();
}

if ($operacao === 'main') {
    $conn->query("UPDATE livros_imagens SET principal = 0 WHERE id_livro = $id_livro");
    $stmt = $conn->prepare("UPDATE livros_imagens SET principal = 1 WHERE id_livro_img = ?");
    $stmt->bind_param("i", $id_foto);
    
    if ($stmt->execute()) {
        header("Location: ../pages/editLivro.php?id=$id_livro&status=capa_atualizada");
    }
    exit();
}