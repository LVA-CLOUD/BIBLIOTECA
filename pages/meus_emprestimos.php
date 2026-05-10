<?php
include_once("../config/verifica_login.php");
include_once("../config/conexao.php");

$id_regi = $_SESSION['id_usuario'];

// Consulta SQL
$sql = "SELECT livros.titulo, livros.id_livro, emprestimos.data_emprestimo, emprestimos.data_devolucao, emprestimos.status
        FROM emprestimos
        INNER JOIN livros ON livros.id_livro = emprestimos.id_livro
        WHERE emprestimos.id_regi = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_regi);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Empréstimos - Biblioteca Athenas</title>

    <!-- CSS PADRÃO DO SISTEMA -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" href="../assets/css/acervoFunci.css">

    <!-- BootsTrap e FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
</head>
</head>

<body>

    <!-- NAVBAR VERTICAL -->
    <nav class="navbar-vertical">

        <div class="logo">
            <img src="../assets/img/LOGOS/logoAthenas.png" alt="">
        </div>

        <div class="navbar-vertical-content">

            <p class="px-3 label-stats mt-4">Principal</p>

            <ul class="nav flex-column px-2">

                <li class="nav-item">
                    <a class="nav-link" href="inicio.php">
                        <i class="fas fa-house"></i> Home
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="acervocliente.php">
                        <i class="fas fa-book"></i> Acervo
                    </a>
                </li>


                <li class="nav-item">
                    <a class="nav-link active" href="#">
                        <i class="fas fa-exchange-alt"></i> Meus Empréstimos
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

    <!-- CONTEÚDO PRINCIPAL -->
    <main class="content">
        <header class="header mb-4">
            <h1 class="h2">Histórico de Empréstimos</h1>
            <p class="text-muted">Gerencie seus livros e prazos de devolução.</p>
        </header>

        <div class="card shadow-lg border-0">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0 text-primary fw-bold">
                    <i class="fas fa-list-ul me-2"></i>Meus Registros
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Livro</th>
                                <th>Data Empréstimo</th>
                                <th>Previsão Devolução</th>
                                <th>Status</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result->num_rows > 0): ?>
                                <?php while ($row = $result->fetch_assoc()):
                                    $data_dev = strtotime($row['data_devolucao']);
                                    $hoje = strtotime(date('Y-m-d'));
                                    $atrasado = ($data_dev < $hoje && $row['status'] == 'aprovado');
                                ?>
                                    <tr>
                                        <td class="ps-4 fw-bold text-dark"><?= htmlspecialchars($row['titulo']) ?></td>
                                        <td><?= date('d/m/Y', strtotime($row['data_emprestimo'])) ?></td>
                                        <td><?= date('d/m/Y', $data_dev) ?></td>
                                        <td>
                                            <?php
                                            if ($row['status'] == 'pendente') {
                                                echo '<span class="badge rounded-pill bg-warning bg-gradient text-dark"><i class="fas fa-clock me-1"></i> Aguardando</span>';
                                            } elseif ($row['status'] == 'aprovado') {
                                                if ($atrasado) {
                                                    echo '<span class="badge rounded-pill bg-danger bg-gradient"><i class="fas fa-exclamation-triangle me-1"></i> Atrasado</span>';
                                                } else {
                                                    echo '<span class="badge rounded-pill bg-success bg-gradient"><i class="fas fa-check me-1"></i> Em dia</span>';
                                                }
                                            } else {
                                                echo '<span class="badge rounded-pill bg-secondary">❌ Negado</span>';
                                            }
                                            ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if ($row['status'] == 'aprovado'): ?>
                                                <a href="../config/devolver.php?id_livro=<?= $row['id_livro'] ?>"
                                                    class="btn btn-sm btn-outline-primary"
                                                    onclick="return confirm('Confirmar a devolução deste livro?')">
                                                    Devolver
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted small">---</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="fas fa-folder-open fa-3x mb-3 d-block"></i>
                                        Você ainda não possui nenhum empréstimo registrado.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <!-- JS DO BOOTSTRAP -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>