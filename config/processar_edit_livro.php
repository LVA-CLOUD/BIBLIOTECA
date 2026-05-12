<?php
include("verifica_funcionario.php");
include_once("conexao.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_livro = $_POST['id_livro'];

    // --- CASO 1: EXCLUSÃO TOTAL DO LIVRO ---
    if (isset($_POST['delete_livro'])) {
        $pasta_livro = "../assets/img/livro_id/" . $id_livro . "/";

        if (is_dir($pasta_livro)) {
            $arquivos = glob($pasta_livro . "*");
            foreach ($arquivos as $arquivo) {
                if (is_file($arquivo)) {
                    unlink($arquivo);
                }
            }
            rmdir($pasta_livro);
        }

        $conn->query("DELETE FROM livros_imagens WHERE id_livro = $id_livro");
        $sql = "DELETE FROM livros WHERE id_livro = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_livro);

        if ($stmt->execute()) {
            header("Location: ../pages/editFunci.php?status=livro_excluido");
        } else {
            echo "Erro ao excluir: " . $conn->error;
        }
        exit();
    }

    // --- CASO 2: ATUALIZAÇÃO DOS DADOS ---
    if (isset($_POST['update_livro'])) {
        $titulo = $_POST['titulo'];
        $ano_publicacao = $_POST['ano_publicacao'] ?? null;
        $quantidade = $_POST['quantidade'];
        $id_autor = $_POST['id_autor'];

        $sql = "UPDATE livros SET titulo = ?, ano_publicacao = ?, quantidade = ?, id_autor = ? WHERE id_livro = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssiii", $titulo, $ano_publicacao, $quantidade, $id_autor, $id_livro);

        if ($stmt->execute()) {
            // --- PROCESSAR NOVAS FOTOS ---
            if (!empty($_FILES['fotos']['name'][0])) {
                $diretorio_base = "../assets/img/livro_id/";
                $pasta_livro = $diretorio_base . $id_livro . "/";

                if (!is_dir($pasta_livro)) {
                    mkdir($pasta_livro, 0777, true);
                }

                foreach ($_FILES['fotos']['tmp_name'] as $key => $tmp_name) {
                    if ($_FILES['fotos']['error'][$key] === 0) {
                        $nome_original = $_FILES['fotos']['name'][$key];
                        $extensao = strtolower(pathinfo($nome_original, PATHINFO_EXTENSION));
                        $novo_nome = uniqid() . "." . $extensao;
                        $destino = $pasta_livro . $novo_nome;

                        if (move_uploaded_file($tmp_name, $destino)) {
                            // AQUI: Salva o caminho completo relativo à raiz do projeto
                            $caminho_banco = "assets/img/livro_id/" . $id_livro . "/" . $novo_nome;
                            
                            $sql_foto = "INSERT INTO livros_imagens (id_livro, caminho, principal) VALUES (?, ?, 0)";
                            $stmt_foto = $conn->prepare($sql_foto);
                            $stmt_foto->bind_param("is", $id_livro, $caminho_banco);
                            $stmt_foto->execute();
                        }
                    }
                }
            }
            header("Location: ../pages/editLivro.php?id=$id_livro&status=sucesso");
        } else {
            echo "Erro ao atualizar: " . $stmt->error;
        }
        exit();
    }
}