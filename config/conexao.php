 <?php
$host = "athenas.mysql.dbaas.com.br";
$user = "athenas";
$pass = "Crocancia123!";
$db   = "athenas";

$conn = new mysqli($host, $user, $pass, $db);

// para informar que é o padrao utf8
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}
?>
