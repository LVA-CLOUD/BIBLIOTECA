<?php
session_start();
include_once("../config/conexao.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM login WHERE nome = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nome);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if (password_verify($senha, $user['senha'])) {

            $_SESSION['usuario'] = $user['nome'];
            header("Location: painel.php");
            exit;
        } else {
            $erro = "Senha incorreta";
        }
    } else {
        $erro = "Usuário não encontrado";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/login.css">
    <title>Login</title>
</head>

<body data-on="false">

    <div class="container">
        <div class="lamp-wrapper">

            <svg class="lamp-svg" viewBox="0 0 200 300">
                <ellipse class="inner-glow" cx="100" cy="110" rx="60" ry="30" />
                <rect class="lamp-base" x="92" y="100" width="16" height="160" rx="8" />
                <rect class="lamp-base" x="60" y="250" width="80" height="12" rx="6" />

                <g class="pull-cord">
                    <line class="cord-line" x1="130" y1="110" x2="130" y2="180" />
                    <circle class="cord-bead" cx="130" cy="190" r="6" />
                    <circle class="cord-hit" cx="130" cy="190" r="25" fill="transparent" />
                </g>

                <path class="lamp-shade" d="M30 110 C 30 50, 170 50, 170 110 C 170 125, 30 125, 30 110 Z" />
            </svg>

        </div>

        <div class="login-form">

            <h2>Bem Vindo!</h2>

            <!-- 🔴 ERRO -->
            <?php if (isset($erro)) echo "<p style='color:red;'>$erro</p>"; ?>

            <form method="POST">

                <div class="form-group">
                    <label>nome</label>
                    <input type="text" name="nome" placeholder="Seu nome" required />
                </div>

                <div class="form-group">
                    <label>nome de usuario</label>
                    <input type="text" name="user" placeholder="Seu nome" required />
                </div>

                <div class="form-group">

                    <label>email</label>
                    <input type="text" name="email" placeholder="Seu nome" required />
                </div>

                <div class="form-group">
                    <label>Senha</label>
                    <input type="senha" name="senha" placeholder="••••••••" required />
                </div>

                <button class="login-btn" type="submit">cadastrar</button>


        </div>
    </div>

    <script src="https://unpkg.co/gsap@3/dist/gsap.min.js"></script>
    <script src="https://unpkg.com/gsap@3/dist/Draggable.min.js"></script>

    <script src="../assets/JS/login.js"></script>
</body>

</html>