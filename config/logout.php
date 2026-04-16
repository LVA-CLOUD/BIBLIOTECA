<?php
session_start(); // Inicia para poder identificar qual sessão destruir
session_unset(); // Limpa as variáveis da sessão
session_destroy(); // Destrói a sessão

// Redireciona para a página inicial que está na raiz
header("Location: ../index.php");
exit();