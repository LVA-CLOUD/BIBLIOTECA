<?php
session_start();
include("../config/conexao.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT r.id_regi, r.senha_regi, r.id_nivel 
            FROM registro r
            INNER JOIN nivel n ON r.id_nivel = n.id_nivel 
            WHERE r.email_regi = ? OR r.user_regi = ? LIMIT 1";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        $user = $result->fetch_assoc();

        if (password_verify($senha, $user['senha_regi'])) {
            $_SESSION['id_usuario'] = $user['id_regi'];
            $_SESSION['id_nivel'] = $user['id_nivel'];

            // para informar o js quem é quem e ser direcionado
            if ($user['id_nivel'] == 2) {
                echo "Login Funcionario";
            } else {
                echo "Login Comum";
            }
            exit;
        } else {
            echo "Senha incorreta!";
        }
    } else {
        echo "Usuário não encontrado!";
    }
    exit;
}
?>



<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS -->
    <link rel="stylesheet" href="../assets/css/login.css">
    <link rel="stylesheet" href="../assets/css/swup.css">
    <title>Login</title>
</head>

<body data-on="false">

    <div class="bibli">
        <h1 class="bg-title" id="bgTitle">BIBLIOTECA ATENAS</h1>
    </div>

    <div class="container">
        <div class="lamp-wrapper">

            <svg class="lamp-svg" viewBox="0 0 200 300" xmlns="http://www.w3.org/2000/svg">
                <ellipse class="inner-glow" cx="100" cy="110" rx="60" ry="30" />

                <rect class="lamp-base" x="92" y="100" width="16" height="160" rx="8" />

                <rect class="lamp-base" x="60" y="250" width="80" height="12" rx="6" />

                <g class="pull-cord">
                    <line class="cord-line" x1="130" y1="110" x2="130" y2="180" />
                    <circle class="cord-bead" cx="130" cy="190" r="6" />
                    <circle class="cord-hit" cx="130" cy="190" r="25" fill="transparent" />
                </g>

                <!-- Mushroom Shade -->
                <path class="lamp-shade" d="M30 110 C 30 50, 170 50, 170 110 C 170 125, 30 125, 30 110 Z" />
            </svg>

        </div>

        <div class="login-form">

            <h2>Bem Vindo!</h2>

            <form method="POST" onsubmit="event.preventDefault(); Login();">

                <div class="form-group">
                    <label>Email/Nome de Usuario</label>
                    <input type="text" id="email" name="email" placeholder="Email/Nome de Usuario" />
                </div>

                <div class="form-group">
                    <label>Senha</label>
                    <input type="password" id="senha" name="senha" placeholder="••••••••" />
                </div>

                <button type="submit" onclick="Login()" class="login-btn">Login</button>

                <div class="ors">
                    <div class="linha"></div>
                    <p>or</p>
                    <div class="linha"></div>
                </div>

                <div class="registro-btn">
                    <a href="registrar.php">Registra-se</a>
                </div>
            </form>

        </div>
    </div>

    <!-- Gsap -->
    <script src="https://unpkg.com/gsap@3/dist/gsap.min.js"></script>
    <script src="https://unpkg.com/gsap@3/dist/Draggable.min.js"></script>
    <!-- JS -->
    <script src="../assets/JS/login.js"></script>

</body>