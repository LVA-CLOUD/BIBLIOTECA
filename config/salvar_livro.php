<?php
include_once("conexao.php");

$titulo = $_POST['titulo'];
$ano = $_POST['ano'];
$id_autor = $_POST['id_autor'];
$quantidade = $_POST['quantidade'];

// 1. Inserir o livro primeiro
$stmt = $conn->prepare("INSERT INTO livros (titulo, ano_publicacao, id_autor, quantidade) VALUES (?, ?, ?, ?)");
$stmt->bind_param("siii", $titulo, $ano, $id_autor, $quantidade);

if ($stmt->execute()) {
    $id_livro = $conn->insert_id; // Pega o ID do livro que acabou de ser criado

    // 2. Verificar se foram enviadas imagens
    if (isset($_FILES['imagens']) && !empty($_FILES['imagens']['name'][0])) {
        
        // Caminho da pasta (ex: ../assets/img/livros/15/)
        $diretorio = "../assets/img/livro_id/" . $id_livro . "/";

        // Cria a pasta se não existir
        if (!is_dir($diretorio)) {
            mkdir($diretorio, 0777, true);
        }

        $arquivos = $_FILES['imagens'];
        
        for ($i = 0; $i < count($arquivos['name']); $i++) {
            $nomeOriginal = $arquivos['name'][$i];
            $extensao = strtolower(pathinfo($nomeOriginal, PATHINFO_EXTENSION));
            
            // Gerar um nome único para a imagem para evitar conflitos
            $novoNome = md5(uniqid($nomeOriginal)) . "." . $extensao;
            $caminhoCompleto = $diretorio . $novoNome;

            // Move o arquivo para a pasta
            if (move_uploaded_file($arquivos['tmp_name'][$i], $caminhoCompleto)) {
                // Define a primeira imagem como a principal (1), as outras como 0
                $principal = ($i === 0) ? 1 : 0;

                // Salva o caminho no banco de dados
                $stmtImg = $conn->prepare("INSERT INTO livros_imagens (id_livro, caminho, principal) VALUES (?, ?, ?)");
                $stmtImg->bind_param("isi", $id_livro, $caminhoCompleto, $principal);
                $stmtImg->execute();
            }
        }
    }

    header("Location: ../pages/cadastro.php?status=success&msg=Livro e imagens cadastrados!");
} else {
    header("Location: ../pages/cadastro.php?status=error&msg=Erro ao cadastrar livro.");
}

$stmt->close();
$conn->close();
exit();
?>