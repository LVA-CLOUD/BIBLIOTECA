<?php
include("verifica_funcionario.php");
include_once("conexao.php");

// Pegamos os dados via GET
$operacao = $_GET['op'] ?? null;
$id_foto = $_GET['id_foto'] ?? null;
$id_livro = $_GET['id_livro'] ?? null;

if (!$operacao || !$id_foto || !$id_livro) {
    die("Erro: Dados insuficientes para completar a operação.");
}

// --- OPERAÇÃO: EXCLUIR FOTO ---
if ($operacao === 'del') {
    
    // 1. Primeiro, buscamos o nome do arquivo no banco para poder apagar da pasta
    $sqlBusca = "SELECT caminho FROM livros_imagens WHERE id_livro_img = ?";
    $stmtBusca = $conn->prepare($sqlBusca);
    $stmtBusca->bind_param("i", $id_foto);
    $stmtBusca->execute();
    $resultado = $stmtBusca->get_result()->fetch_assoc();

    if ($resultado) {
        // O caminho deve ser: pasta_base / id_do_livro / nome_do_arquivo
        $caminho_arquivo = "../assets/img/livro_id/" . $id_livro . "/" . $resultado['caminho'];
        
        // Deleta o arquivo físico do servidor
        if (file_exists($caminho_arquivo)) {
            unlink($caminho_arquivo);
        }

        // 2. Agora deletamos o registo no banco de dados
        $sqlDel = "DELETE FROM livros_imagens WHERE id_livro_img = ?";
        $stmtDel = $conn->prepare($sqlDel);
        $stmtDel->bind_param("i", $id_foto);
        
        if ($stmtDel->execute()) {
            header("Location: ../pages/editLivro.php?id=$id_livro&status=foto_excluida");
        } else {
            echo "Erro ao eliminar do banco: " . $conn->error;
        }
    } else {
        echo "Erro: Imagem não encontrada no banco de dados.";
    }
    exit();
}

// --- OPERAÇÃO: TORNAR PRINCIPAL (CAPA) ---
if ($operacao === 'main') {
    // Reseta todas as fotos deste livro
    $conn->query("UPDATE livros_imagens SET principal = 0 WHERE id_livro = $id_livro");

    // Define a nova como principal
    $stmt = $conn->prepare("UPDATE livros_imagens SET principal = 1 WHERE id_livro_img = ?");
    $stmt->bind_param("i", $id_foto);
    
    if ($stmt->execute()) {
        header("Location: ../pages/editLivro.php?id=$id_livro&status=capa_atualizada");
    }
    exit();
}