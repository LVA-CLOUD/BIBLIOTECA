<?php
// Não use session_start aqui se já usou na página que vai incluir este arquivo

function verificarFuncionario() {
    if (!isset($_SESSION['nivel']) || $_SESSION['nivel'] !== 'funcionario') {
        header("Location: ../inicio/index.php");
        exit;
    }
}

function verificarLogado() {
    if (!isset($_SESSION['id_regi'])) {
        header("Location: ../pages/login.php");
        exit;
    }
}
?>