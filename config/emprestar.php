<?php
session_start();

// 1. CONEXÃO COM O BANCO
include_once("conexao.php");

// 2. VERIFICAÇÃO DE LOGIN
if (!isset($_SESSION['id_usuario'])) {
    die("Erro: Sessão não encontrada. Por favor, faça login novamente.");
}

// 3. TRATAMENTO DOS DADOS RECEBIDOS
if (!isset($_GET['id_livro'])) {
    die("Erro: ID do livro não informado.");
}

$id_sessao = $_SESSION['id_usuario']; // Pega o ID de quem está logado
$id_livro  = (int) $_GET['id_livro'];

// 4. CONFIGURAÇÃO DE DATAS
$data_emprestimo = date('Y-m-d');
$data_devolucao  = date('Y-m-d', strtotime('+10 days'));

/**
 * 5. EXECUÇÃO COM PREPARED STATEMENTS
 * Isso evita erros de sintaxe e protege contra ataques (SQL Injection)
 */
$sql = "INSERT INTO emprestimos (id_regi, id_livro, data_emprestimo, data_devolucao, status)
        VALUES (?, ?, ?, ?, 'pendente')";

$stmt = $conn->prepare($sql);

if ($stmt) {
    // "iiss" significa: integer, integer, string, string (os tipos de dados abaixo)
    $stmt->bind_param("iiss", $id_sessao, $id_livro, $data_emprestimo, $data_devolucao);
    
    if ($stmt->execute()) {
        // Redireciona de volta para o acervo com sucesso
        header("Location: ../pages/meus_emprestimos.php?sucesso=1");
        exit();
    } else {
        echo "Erro ao gravar no banco: " . $stmt->error;
    }
} else {
    echo "Erro na preparação do SQL: " . $conn->error;
}
?>