<?php
session_start();

/**
 * 1. CONEXÃO
 * Ajustado para buscar dentro da pasta 'config', 
 * já que o emprestar.php está na raiz.
 */
if (file_exists("./config/conexao.php")) {
    include_once("./config/conexao.php");
} else {
    die("Erro crítico: O arquivo ./config/conexao.php não foi encontrado.");
}

/**
 * 2. VERIFICAÇÃO DE LOGIN
 */
if (!isset($_SESSION['id_regi'])) {
    die("Erro: Você precisa estar logado. Verifique se a variável 'id_regi' existe na sua sessão.");
}

/**
 * 3. VERIFICAÇÃO DA CONEXÃO
 */
if (!isset($conn) || $conn->connect_error) {
    die("Erro de conexão: Variável \$conn não definida ou falha na conexão. Verifique o arquivo conexao.php.");
}

/**
 * 4. TRATAMENTO DOS DADOS RECEBIDOS
 */
if (!isset($_GET['id_livro'])) {
    die("Erro: ID do livro não informado.");
}

$id_regi  = $_SESSION['id_regi'];
$id_livro = (int) $_GET['id_livro'];

/**
 * 5. VERIFICAR SE O LIVRO JÁ ESTÁ EMPRESTADO
 */
$check = $conn->query("SELECT * FROM emprestimos WHERE id_livro = $id_livro AND status = 'emprestado'");

if ($check && $check->num_rows > 0) {
    die("Este livro já está emprestado.");
}

/**
 * 6. CONFIGURAÇÃO DE DATAS
 */
$data_emprestimo = date('Y-m-d');
$data_devolucao  = date('Y-m-d', strtotime('+10 days'));

/**
 * 7. EXECUÇÃO DO EMPRÉSTIMO
 */
$sql = "INSERT INTO emprestimos 
        (id_regi, id_livro, data_emprestimo, data_devolucao, status)
        VALUES ($id_regi, $id_livro, '$data_emprestimo', '$data_devolucao', 'emprestado')";

if ($conn->query($sql)) {
    /**
     * REDIRECIONAMENTO:
     * Se o emprestar.php está na RAIZ, basta voltar para index.php diretamente.
     */
    header("Location: index.php?sucesso=1");
    exit();
} else {
    echo "Erro ao processar o banco de dados: " . $conn->error;
}
?>