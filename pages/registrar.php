<?php
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

    // Senha criptografada
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    // 1. VERIFICAÇÃO de duplicidade
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
        // 2. INSERÇÃO (Agora incluindo a coluna de nível)
        // Ajuste 'id_nivel' para o nome exato da coluna na sua tabela
        $sql_ins = "INSERT INTO registro (nome_regi, user_regi, email_regi, senha_regi, id_nivel) VALUES (?, ?, ?, ?, ?)";

        $stmt_ins = $conn->prepare($sql_ins);

        $stmt_ins->bind_param("ssssi", $nome, $user, $email, $senhaHash, $nivel_padrao);

        if ($stmt_ins->execute()) {
            unset($_SESSION['google_data']); // Limpa dados temporários
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
        </div>


        <script src="https://unpkg.com/gsap@3/dist/gsap.min.js"></script>
        <script src="https://unpkg.com/gsap@3/dist/Draggable.min.js"></script>

        <script src="../assets/JS/login.js"></script>
</body>

</html>