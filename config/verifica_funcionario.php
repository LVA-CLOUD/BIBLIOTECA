<?php
session_start();

if (!isset($_SESSION['id_usuario']) || $_SESSION['id_nivel'] != 2) {
    echo "Acesso negado!";
    exit;
}
?>