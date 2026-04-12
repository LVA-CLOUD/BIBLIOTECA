<?php
include 'conexao.php';

$metodo = $_SERVER['REQUEST_METHOD'];

// LISTAR LIVROS
if ($metodo == 'GET') {
    $sql = "SELECT id_livro, titulo, ano_publicacao FROM livros";
    $result = $conn->query($sql);
    $livros = [];
    while($row = $result->fetch_assoc()) {
        $livros[] = $row;
    }
    echo json_encode($livros);
}

// SALVAR LIVRO
if ($metodo == 'POST') {
    $titulo = $_POST['titulo'];
    $ano = $_POST['ano'];
    
    $sql = "INSERT INTO livros (titulo, ano_publicacao) VALUES ('$titulo', '$ano')";
    if ($conn->query($sql)) {
        echo json_encode(["status" => "sucesso"]);
    }
}
?>