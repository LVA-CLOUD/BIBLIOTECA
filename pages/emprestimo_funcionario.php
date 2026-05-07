<?php
include_once("../config/verifica_funcionario.php");
include_once("../config/conexao.php");

$id_regi = $_SESSION['id_usuario'];

// 1. Consulta para solicitações PENDENTES (Ações de Aprovar/Negar)
$sqlPendente = "SELECT e.id, l.titulo, e.data_emprestimo, r.user_regi as nome_usuario 
        FROM emprestimos e
        INNER JOIN livros l ON l.id_livro = e.id_livro
        INNER JOIN registro r ON r.id_regi = e.id_regi
        WHERE e.status = 'pendente'";
$resultPendente = $conn->query($sqlPendente);

// 2. Consulta para livros que já estão COM OS USUÁRIOS (Status aprovado)
$sqlAprovados = "SELECT e.id, l.titulo, e.data_emprestimo, r.user_regi as nome_usuario 
        FROM emprestimos e
        INNER JOIN livros l ON l.id_livro = e.id_livro
        INNER JOIN registro r ON r.id_regi = e.id_regi
        WHERE e.status = 'aprovado'";
$resultAprovados = $conn->query($sqlAprovados);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Empréstimos - Biblioteca Athenas</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
    <!-- CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/emprestimoFuncionario.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>

<body>

    <!-- NAV (Mantida igual ao seu original) -->
    <nav class="navbar-vertical">
        <div class="logo"><img src="../assets/img/LOGOS/logoAthenas.png" alt=""></div>
        <div class="navbar-vertical-content">
            <ul class="nav flex-column px-2">
                <li class="nav-item"><a class="nav-link" href="dashboard.php"><i class="fas fa-chart-pie"></i> Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="acervofuncionario.php"><i class="fas fa-book"></i> Acervo</a></li>
                <li class="nav-item"><a class="nav-link active" href="#"><i class="fas fa-exchange-alt"></i> Empréstimos</a></li>
                <li class="nav-item"><a class="nav-link" href="cadastro.php"><i class="fas fa-plus-circle"></i> Cadastro</a></li>
                <li class="nav-item"><a class="nav-link" href="editFunci.php"><i class="fas fa-pen"></i> Editar Livros</a></li>
            </ul>
            <div class="mt-4"><button onclick="window.location.href='../config/logout.php'" class="btn w-100">Sair</button></div>
        </div>
    </nav>

    <main class="content">
        <header class="header">
            <h1>Gerenciamento de Empréstimos</h1>
        </header>

        <!-- Solicitações Pendentes -->
        <div class="subTitulo mb-1"><small>Solicitações</small></div>
        <section class="card mb-4">
            <div class="card-header bg-primary text-light"><strong>Solicitações Pendentes</strong></div>

            <table class="tabela shadow-lg">
                <thead>
                    <tr class="border-bottom">
                        <th>Usuário</th>
                        <th>Livro</th>
                        <th>Data Pedido</th>
                        <th>Ação</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if ($resultPendente->num_rows > 0): ?>
                        <?php while ($row = $resultPendente->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['nome_usuario']) ?></td>
                                <td><?= htmlspecialchars($row['titulo']) ?></td>
                                <td><?= date('d/m/Y', strtotime($row['data_emprestimo'])) ?></td>
                                <td>
                                    <a href="../config/processar_status.php?id=<?= $row['id'] ?>&acao=aprovado" class="btn-ok">Aprovar</a>
                                    <a href="../config/processar_status.php?id=<?= $row['id'] ?>&acao=negado" class="btn-negativo">Negar</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center">Nenhuma solicitação pendente.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>

        <!-- Livros Emprestados -->
        <div class="subTitulo mt-2 mb-1"><small>Emprestados</small></div>
        <section class="card">
            <div class="card-header bg-primary text-light"><strong>Livros Atualmente Emprestados</strong></div>

            <table class="tabela shadow-lg">
                <thead>
                    <tr class="border-bottom">
                        <th>Usuário</th>
                        <th>Livro Emprestado</th>
                        <th>Data de Saída</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($resultAprovados->num_rows > 0): ?>
                        <?php while ($row = $resultAprovados->fetch_assoc()): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($row['nome_usuario']) ?></strong></td>
                                <td><?= htmlspecialchars($row['titulo']) ?></td>
                                <td><?= date('d/m/Y', strtotime($row['data_emprestimo'])) ?></td>
                                <td><span class="status-badge">Em posse</span></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center">Nenhum livro circulando no momento.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </main>
</body>

</html>