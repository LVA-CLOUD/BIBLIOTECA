<?php
include("../config/verifica_funcionario.php");
include_once("../config/conexao.php");

// --- BUSCA DE DADOS ---

// Total de Livros (Soma da coluna quantidade)
$resTotalLivros = $conn->query("SELECT SUM(quantidade) as total FROM livros");
$rowTotal = $resTotalLivros->fetch_assoc();
$totalLivros = (int)($rowTotal['total'] ?? 0);

// Total de Empréstimos Ativos (Onde a data de devolução ainda é nula)
$resEmprestimosAtivos = $conn->query("SELECT COUNT(*) as total FROM emprestimos WHERE status != 'devolvido'");
$rowAtivos = $resEmprestimosAtivos->fetch_assoc();
$totalAtivos = (int)($rowAtivos['total'] ?? 0);

// Cálculo de Disponibilidade
$porcentagemDisponivel = 0;
if ($totalLivros > 0) {
    // Garante que o cálculo não resulte em números negativos se houver erro de inventário
    $calculo = (($totalLivros - $totalAtivos) / $totalLivros) * 100;
    $porcentagemDisponivel = round(max(0, $calculo));
}

// Ranking de Livros Mais Emprestados
$sqlRanking = "SELECT l.titulo, COUNT(e.id) as qtd 
               FROM livros l 
               LEFT JOIN emprestimos e ON l.id_livro = e.id_livro 
               GROUP BY l.id_livro 
               ORDER BY qtd DESC LIMIT 5";
$rankingLivros = $conn->query($sqlRanking);
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Biblioteca Falcon</title>

    <!-- GSTATIC -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <!-- GOOGLE -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap" rel="stylesheet">
    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FONTAWESOME -->
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
    <!-- CSS -->
    <link rel="stylesheet" href="../assets/css/dashboard.css">

</head>

<body>

    <nav class="navbar-vertical">

        <div class="logo">
            <img src="../assets/img/LOGOS/logoAthenas.png" alt="">
        </div>

        <div class="navbar-vertical-content">

            <p class="px-3 label-stats mt-4">Principal</p>

            <ul class="nav flex-column px-2">
                <li class="nav-item">

                    <a class="nav-link active" href="dashboard.php">
                        <i class="fas fa-chart-pie"></i> Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="acervofuncionario.php">
                        <i class="fas fa-book"></i> Acervo
                    </a>
                </li>


                <li class="nav-item">
                    <a class="nav-link" href="emprestimo_funcionario.php">
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

    <main class="content">
        <!-- HEADER -->
        <div class="row justify-content-between align-items-center mb-4">

            <div class="col-auto">
                <h3 class="mb-0">Resumo da Biblioteca</h3>
            </div>

            <div class="col-auto">
                <div class="text-muted fw-semi-bold"><?php echo date('d \d\e F, Y'); ?></div>
            </div>
        </div>

        <!-- CARDS ESTATÍSTICOS -->
        <div class="row g-3 mb-4">

            <div class="col-md-4">
                <div class="card-stats">

                    <div class="label-stats">Livros no Acervo</div>

                    <span class="display-stats"><?= $totalLivros ?></span>

                    <div class="mt-2"><span class="badge bg-soft-info">Total de exemplares</span></div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card-stats">
                    <div class="label-stats">Empréstimos Atuais</div>

                    <span class="display-stats text-warning"><?= $totalAtivos ?></span>

                    <div class="mt-2"><span class="badge bg-soft-info" style="background-color: #fff3cd; color: #856404;">Aguardando devolução</span></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-stats">

                    <div class="label-stats">Disponibilidade</div>

                    <span class="display-stats text-success"><?= $porcentagemDisponivel ?>%</span>

                    <div class="mt-2"><span class="badge bg-soft-success">Itens disponíveis</span></div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- TABELA DE RANKING -->
            <div class="col-lg-8">

                <div class="card card-table h-100">

                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 text-800">Livros Mais Populares</h5>
                    </div>

                    <div class="card-body p-0">

                        <div class="table-responsive">

                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th>Título do Livro</th>
                                        <th class="text-center">Total de Saídas</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php if ($rankingLivros && $rankingLivros->num_rows > 0): ?>
                                        <?php while ($livro = $rankingLivros->fetch_assoc()): ?>
                                            <tr>
                                                <td class="fw-bold"><?= htmlspecialchars($livro['titulo']) ?></td>
                                                <td class="text-center">
                                                    <span class="badge rounded-pill bg-light text-dark border">
                                                        <?= $livro['qtd'] ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <?php if ($livro['qtd'] > 0): ?>
                                                        <span class="text-success small fw-bold"><i class="fas fa-arrow-up me-1"></i> Alta Demanda</span>
                                                    <?php else: ?>
                                                        <span class="text-muted small">Sem registros</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="3" class="text-center py-4">Nenhum dado encontrado.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CARD LATERAL INFORMATIVO -->
            <div class="col-lg-4">
                <div class="card bg-primary text-white border-0 h-100">

                    <div class="card-body p-4">

                        <div class="mb-3"><i class="fas fa-info-circle fa-2x opacity-25"></i></div>

                        <h4>Dica do Sistema</h4>

                        <p class="small opacity-75">
                            O ranking ao lado leva em conta todos os empréstimos realizados desde o início do sistema.
                            Use esses dados para planejar a compra de novos exemplares dos títulos mais procurados.
                        </p>

                        <hr class="opacity-25">

                        <a href="acervofuncionario.php" class="btn btn-sm btn-light w-100 fw-bold">Gerenciar Acervo</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>