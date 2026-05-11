<?php
include_once("conexao.php");

// Coleta os dados do formulário
$titulo     = $_POST['titulo'];
$ano        = $_POST['ano'];
$id_autor   = $_POST['id_autor'];
$categoria  = $_POST['categoria'];
$quantidade = $_POST['quantidade'];
$destaque   = isset($_POST['destaque']) ? 1 : 0;

// 1. Inserir na tabela 'livros' (Exatamente como suas colunas: titulo, ano_publicacao, id_autor, categoria, quantidade, destaque)
$sql = "INSERT INTO livros (titulo, ano_publicacao, id_autor, categoria, quantidade, destaque) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

// s = string, i = integer
// Ordem: titulo(s), ano(i), id_autor(i), categoria(s), quantidade(i), destaque(i)
$stmt->bind_param("siissi", $titulo, $ano, $id_autor, $categoria, $quantidade, $destaque);

if ($stmt->execute()) {
    $id_livro = $conn->insert_id; // Pega o ID gerado pelo AUTO_INCREMENT

    // 2. Processar Imagens
    if (isset($_FILES['imagens']) && !empty($_FILES['imagens']['name'][0])) {
        
        // Caminho baseado no ID do livro para organizar as pastas
        $diretorio = "../assets/img/livro_id/" . $id_livro . "/";

        if (!is_dir($diretorio)) {
            mkdir($diretorio, 0777, true);
        }

        $arquivos = $_FILES['imagens'];
        
        for ($i = 0; $i < count($arquivos['name']); $i++) {
            if ($arquivos['error'][$i] === 0) {
                $extensao = strtolower(pathinfo($arquivos['name'][$i], PATHINFO_EXTENSION));
                $novoNome = md5(uniqid()) . "." . $extensao;
                $caminhoNoBanco = "assets/img/livro_id/" . $id_livro . "/" . $novoNome;
                $destinoFisico = "../" . $caminhoNoBanco;

                if (move_uploaded_file($arquivos['tmp_name'][$i], $destinoFisico)) {
                    // A primeira imagem do loop será a principal
                    $principal = ($i === 0) ? 1 : 0;

                    // 3. Inserir na tabela 'livros_imagens'
                    $stmtImg = $conn->prepare("INSERT INTO livros_imagens (id_livro, caminho, principal) VALUES (?, ?, ?)");
                    $stmtImg->bind_param("isi", $id_livro, $caminhoNoBanco, $principal);
                    $stmtImg->execute();
                }
            }
        }
    }
    header("Location: ../pages/cadastro.php?status=success&msg=Livro cadastrado com sucesso!");
} else {
    header("Location: ../pages/cadastro.php?status=error&msg=Erro ao salvar: " . $conn->error);
}

$stmt->close();
$conn->close();
exit();