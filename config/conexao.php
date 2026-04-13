<?php
$host = "athenas.mysql.dbaas.com.br";
$user = "athenas";
$pass = "Crocancia123!";
$db   = "athenas";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}
?>