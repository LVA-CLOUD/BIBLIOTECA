<?php
include("verifica_funcionario.php");
include_once("conexao.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_livro = $_POST['id_livro'];

    // --- CASO 1: EXCLUSÃO TOTAL DO LIVRO ---
    if (isset($_POST['delete_livro'])) {

        // --- NOVIDADE: APAGAR PASTA FÍSICA DO LIVRO ---
        $pasta_livro = "../assets/img/livro_id/" . $id_livro . "/";

        if (is_dir($pasta_livro)) {
            // Pega todos os arquivos dentro da pasta
            $arquivos = glob($pasta_livro . "*");
            foreach ($arquivos as $arquivo) {
                if (is_file($arquivo)) {
                    unlink($arquivo); // Deleta cada arquivo (fotos)
                }
            }
            rmdir($pasta_livro); // Deleta a pasta agora que está vazia
        }

        // --- EXCLUSÃO NO BANCO DE DADOS ---
        // Primeiro deletamos as referências das imagens no banco (se não tiver cascade)
        $conn->query("DELETE FROM livros_imagens WHERE id_livro = $id_livro");

        // Depois deletamos o livro
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
        // Ajustado para 'ano_publicacao' para coincidir com seu formulário
        $ano_publicacao = $_POST['ano_publicacao'] ?? null;
        $quantidade = $_POST['quantidade'];
        $id_autor = $_POST['id_autor'];

        // Ajustado o SQL para usar a coluna 'ano_publicacao'
        $sql = "UPDATE livros SET titulo = ?, ano_publicacao = ?, quantidade = ?, id_autor = ? WHERE id_livro = ?";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            die("Erro no banco de dados: " . $conn->error);
        }

        $stmt->bind_param("ssiii", $titulo, $ano_publicacao, $quantidade, $id_autor, $id_livro);

        if ($stmt->execute()) {
            // --- PROCESSAR NOVAS FOTOS ---
            if (!empty($_FILES['fotos']['name'][0])) {
                // 1. Caminho base onde ficam as pastas por ID
                $diretorio_base = "../assets/img/livro_id/";

                // 2. Caminho específico da pasta do livro (ex: ../assets/img/livro_id/298/)
                $pasta_livro = $diretorio_base . $id_livro . "/";

                // 3. Verifica se a pasta já existe. Se não, cria com permissão 0777
                if (!is_dir($pasta_livro)) {
                    mkdir($pasta_livro, 0777, true);
                }

                foreach ($_FILES['fotos']['tmp_name'] as $key => $tmp_name) {
                    if ($_FILES['fotos']['error'][$key] === 0) {
                        $nome_original = $_FILES['fotos']['name'][$key];
                        $extensao = strtolower(pathinfo($nome_original, PATHINFO_EXTENSION));

                        // Gera um nome único para a imagem
                        $novo_nome = uniqid() . "." . $extensao;

                        // O destino agora inclui a subpasta do ID
                        $destino = $pasta_livro . $novo_nome;

                        if (move_uploaded_file($tmp_name, $destino)) {
                            // No banco, você continua salvando apenas o nome do arquivo 
                            // ou o caminho relativo, conforme sua preferência.
                            $sql_foto = "INSERT INTO livros_imagens (id_livro, caminho, principal) VALUES (?, ?, 0)";
                            $stmt_foto = $conn->prepare($sql_foto);
                            $stmt_foto->bind_param("is", $id_livro, $novo_nome);
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
