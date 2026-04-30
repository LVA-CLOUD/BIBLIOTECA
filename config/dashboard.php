<?php
session_start();

if ($_SESSION['id_nivel'] == 1) {
    header("Location: ../pages/inicio.php");
    exit;
} elseif ($_SESSION['id_nivel'] == 2) {
    header("Location: ../pages/acervofuncionario.php");
    exit;
} else {
    header("Location: ../pages/inicio.php");
    exit;
}
