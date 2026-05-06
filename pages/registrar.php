<?php
session_start();
include_once("../config/conexao.php");

// Captura dados do Google se existirem
$nomePreenchido = $_SESSION['google_data']['nome'] ?? '';
$emailPreenchido = $_SESSION['google_data']['email'] ?? '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome  = $_POST['nome'];
    $user  = $_POST['user'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $nivel_padrao = 1;

    // Criptografia da senha
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    // Verifica duplicidade
    $sql_check = "SELECT id_regi FROM registro WHERE user_regi = ? OR email_regi = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("ss", $user, $email);
    $stmt_check->execute();

    $res_check = $stmt_check->get_result();
    $existe = $res_check->num_rows;
    $stmt_check->close();

    if ($existe > 0) {
        $erro = "Usuário ou E-mail já cadastrados!";
    } else {

        $sql_ins = "INSERT INTO registro (nome_regi, user_regi, email_regi, senha_regi, id_nivel) VALUES (?, ?, ?, ?, ?)";
        $stmt_ins = $conn->prepare($sql_ins);
        $stmt_ins->bind_param("ssssi", $nome, $user, $email, $senhaHash, $nivel_padrao);

        if ($stmt_ins->execute()) {

            // ===== ENVIO DE EMAIL COM BREVO =====

            require_once("../config/env.php");

            $apiKey = $BREVO_API_KEY;

            $data = [
                "sender" => [
                    "name" => "Biblioteca-Athenas",
                    "email" => "06luis.alves@gmail.com"
                ],
                "to" => [
                    [
                        "email" => $email,
                        "name" => $nome
                    ]
                ],
                "subject" => "Cadastro realizado com sucesso",
                "htmlContent" => "
                    <h2>Olá, $nome!</h2>
                    <p>Seu cadastro foi realizado com sucesso.</p>
                    <p>Agora você já pode acessar o sistema.</p>
                "
            ];

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, "https://api.brevo.com/v3/smtp/email");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "accept: application/json",
                "api-key: $apiKey",
                "content-type: application/json"
            ]);

            $response = curl_exec($ch);
            $erroCurl = curl_error($ch);
            curl_close($ch);

            // (opcional) debug
            echo $response;
            exit;

            //  unset($_SESSION['google_data']);
            header("Location: login.php?cadastro=sucesso");
            exit;
        } else {
            $erro = "Erro ao registrar: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../assets/css/login.css">
    <title>Cadastre-se</title>
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

            <?php if (isset($erro)): ?>
                <p style="color:red; font-weight:bold;"><?php echo $erro; ?></p>
            <?php endif; ?>

            <?php if (isset($erro)) echo "<p style='color:red;'>$erro</p>"; ?>

            <form method="POST" action="">
                <div class="form-group">

                    <label>Nome</label>
                    <input type="text" name="nome" value="<?php echo htmlspecialchars($nomePreenchido); ?>" required />
                </div>

                <div class="form-group">
                    <label>Usuário</label>
                    <input type="text" name="user" required />
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($emailPreenchido); ?>" required <?php echo !empty($emailPreenchido) ? 'readonly' : ''; ?> />
                </div>

                <div class="form-group">
                    <label>Senha</label>
                    <input type="password" name="senha" required />
                </div>

                <button class="login-btn" type="submit">Cadastrar</button>
            </form>

        </div>

        <!-- Gsap -->
        <script src="https://unpkg.com/gsap@3/dist/gsap.min.js"></script>
        <script src="https://unpkg.com/gsap@3/dist/Draggable.min.js"></script>
        <!-- JS -->
        <script src="../assets/JS/login.js"></script>
</body>

</html>