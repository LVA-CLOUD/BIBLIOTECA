<?php
include_once("verifica_login.php"); // Caminho direto pois estão na mesma pasta
include_once("conexao.php");

$id_livro = filter_input(INPUT_GET, 'id_livro', FILTER_VALIDATE_INT);
$id_usuario = $_SESSION['id_usuario'];
$data_hoje = date('Y-m-d');

// Definimos uma data de devolução padrão (ex: 7 dias)
$data_devolucao = date('Y-m-d', strtotime('+7 days'));

if ($id_livro && $id_usuario) {
    // Inserimos com o status 'pendente'
    $sql = "INSERT INTO emprestimos (id_regi, id_livro, data_emprestimo, data_devolucao, status) VALUES (?, ?, ?, ?, 'pendente')";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiss", $id_usuario, $id_livro, $data_hoje, $data_devolucao);

    if ($stmt->execute()) {
        // Redireciona de volta para o acervo com uma mensagem de sucesso
        header("Location: ../pages/acervocliente.php?sucesso=1");
        exit();
    } else {
        echo "Erro ao processar solicitação: " . $conn->error;
    }
} else {
    header("Location: ../view/acervocliente.php?sucesso=1");
    exit();
}
