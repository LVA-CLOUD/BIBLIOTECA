<?php
include_once("../config/verifica_funcionario.php");
include_once("../config/conexao.php");



$id_regi = $_SESSION['id_usuario'];

// Altere a SQL para buscar status pendente e incluir o nome do usuário (id_regi)
$sql = "SELECT e.id, l.titulo, e.data_emprestimo, r.user_regi as nome_usuario 
        FROM emprestimos e
        INNER JOIN livros l ON l.id_livro = e.id_livro
        INNER JOIN registro r ON r.id_regi = e.id_regi
        WHERE e.status = 'pendente'";

$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Empréstimos</title>
    <!-- GSTATIC -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FONTAWESOME -->
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
    <!-- CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/logout.css">
    <link rel="stylesheet" href="../assets/css/emprestimoFuncionario.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>

<body>

    <nav class="navbar-vertical">

        <div class="logo">
            <img src="../assets/img/LOGOS/logoAthenas.png" alt="">
        </div>

        <div class="navbar-vertical-content">

            <ul class="nav flex-column px-2">
                <li class="nav-item">

                    <a class="nav-link" href="dashboard.php">
                        <i class="fas fa-chart-pie"></i> Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="acervofuncionario.php">
                        <i class="fas fa-book"></i> Acervo
                    </a>
                </li>


                <li class="nav-item">
                    <a class="nav-link active" href="#">
                        <i class="fas fa-exchange-alt"></i> Empréstimos
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="cadastro.php">
                        <i class="fas fa-plus-circle"></i> Cadastro
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="editFunci.php">
                        <i class="fas fa-pen"></i> Editar Livros
                    </a>
                </li>
            </ul>

            <div class="row-sair"></div>

            <div class="mt-4">
                <button onclick="window.location.href='../config/logout.php'" class="btn w-100">
                    Sair
                </button>
            </div>
        </div>
    </nav>

    <!-- 📖 CONTEÚDO -->
    <main class="content">

        <header class="header">
            <h1>Empréstimos</h1>
        </header>

        <section class="card">

            <table class="tabela">
                <tr>
                    <th>Usuario</th>
                    <th>Livro</th>
                    <th>Ação</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['nome_usuario'] ?></td>
                        <td><?= $row['titulo'] ?></td>
                        <td>
                            <a href="../config/processar_status.php?id=<?= $row['id'] ?>&acao=aprovado" class="btn-ok">Aprovar</a>
                            <a href="../config/processar_status.php?id=<?= $row['id'] ?>&acao=negado" class="btn-negativo">Negar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>

            </table>

        </section>

    </main>

</body>

</html>