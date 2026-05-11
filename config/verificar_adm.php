<?php
session_start();

// verifica se está logado
if (!isset($_SESSION['id_usuario'])) {

    header("Location: ../pages/login.php");
    exit;
}

// verifica se NÃO é administrador
if ($_SESSION['id_nivel'] != 3) {

    header("Location: ./pages/cadastroadm.php"); // ou inicio.php se preferir
    exit;
}
?>