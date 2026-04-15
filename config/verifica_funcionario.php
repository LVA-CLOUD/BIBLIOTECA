<?php
session_start();

if (!isset($_SESSION['id_usuario']) || $_SESSION['id_nivel'] != 2) {

    // verifiacar qual pagina a pessoa estava antes
    // o "HTTP_REFERER" é como se fosse um rastro que a pessoa deixou antes de ir para outra pagina
    if (isset($_SERVER['HTTP_REFERER'])) {
        header("Location: " . $_SERVER['HTTP_REFERER'] . "?erro=negado");
    } else {
        // Se não tiver historico ira mandar para a pagiga de login
        header("Location: login.php");
    }
    exit;
}
?>