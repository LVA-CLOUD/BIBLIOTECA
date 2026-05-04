<?php
session_start(); // Inicia para poder identificar qual sessão destruir
session_unset(); // Limpa as variáveis da sessão
session_destroy(); // Destrói a sessão

header("Location: ../index.php");
exit();