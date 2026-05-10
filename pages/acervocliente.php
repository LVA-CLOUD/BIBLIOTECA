<?php
include("../config/verifica_login.php");
include_once("../config/conexao.php");

$idAutor = filter_input(INPUT_GET, 'autor', FILTER_VALIDATE_INT);
$categoria = $_GET['categoria'] ?? null;
$pesquisa = $_GET['pesquisa'] ?? null;

// BUSCA DE AUTORES
$sqlAutores = "SELECT id_autor, nome FROM autores ORDER BY nome";
$autores = $conn->query($sqlAutores);

$sqlLivros = "SELECT 
                l.id_livro, 
                l.titulo, 
                l.ano_publicacao, 
                l.categoria, 
                l.quantidade,
                a.nome as nome_autor,
                (SELECT COUNT(*) 
                 FROM emprestimos e 
                 WHERE e.id_livro = l.id_livro 
                 AND e.status IN ('emprestado', 'aprovado')) as total_emprestados
              FROM livros l
              INNER JOIN autores a ON l.id_autor = a.id_autor";


$condicoes = [];
$params = [];
$tipos = "";

if ($idAutor) {
    $condicoes[] = "a.id_autor = ?";
    $params[] = $idAutor;
    $tipos .= "i";
}

if (!empty($categoria)) {
    $condicoes[] = "l.categoria = ?";
    $params[] = $categoria;
    $tipos .= "s";
}

if (!empty($pesquisa)) {
    $condicoes[] = "(l.titulo LIKE ? OR a.nome LIKE ?)";
    $termo = "%$pesquisa%";
    $params[] = $termo;
    $params[] = $termo;
    $tipos .= "ss";
}

if (count($condicoes) > 0) {
    $sqlLivros .= " WHERE " . implode(" AND ", $condicoes);
}

$stmt = $conn->prepare($sqlLivros);
if (count($params) > 0) {
    $stmt->bind_param($tipos, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acervo - Biblioteca Athenas</title>

    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" href="../assets/css/acervoFunci.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
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
                    <a class="nav-link" href="inicio.php">
                        <i class="fas fa-house"></i> Home
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" href="#">
                        <i class="fas fa-book"></i> Acervo
                    </a>
                </li>


                <li class="nav-item">
                    <a class="nav-link" href="meus_emprestimos.php">
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

    <main class="content">
        <header class="header mb-4">
            <h1 class="h2">Biblioteca Imperial de Atenas</h1>
        </header>

        <!-- FILTROS -->
        <section class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <form method="GET" class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Pesquisa Livre</label>
                        <input type="text" name="pesquisa" class="form-control" placeholder="Título ou Autor..." value="<?= htmlspecialchars($_GET['pesquisa'] ?? '') ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Autor</label>
                        <select name="autor" class="form-select">
                            <option value="">Todos</option>
                            <?php $autores->data_seek(0);
                            while ($autor = $autores->fetch_assoc()): ?>
                                <option value="<?= $autor['id_autor'] ?>" <?= ($idAutor == $autor['id_autor']) ? 'selected' : '' ?>><?= $autor['nome'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Categoria</label>
                        <select name="categoria" class="form-select">
                            <option value="">Todas</option>
                            <?php $cats = ["Terror", "Romance", "Suspense", "Ficção"];
                            foreach ($cats as $c): ?>
                                <option value="<?= $c ?>" <?= ($categoria == $c) ? 'selected' : '' ?>><?= $c ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Filtrar</button>
                    </div>
                </form>
            </div>
        </section>

        <!-- LISTAGEM -->
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php while ($livro = $result->fetch_assoc()):
                $disponiveis = $livro['quantidade'] - $livro['total_emprestados'];
                $esgotado = ($disponiveis <= 0);
            ?>
                <div class="col">
                    <div class="card h-100 border-0 shadow-lg position-relative">
                        <!-- Badge de Status -->
                        <div class="position-absolute top-0 end-0 m-3">
                            <span class="badge <?= $esgotado ? 'bg-danger bg-gradient' : 'bg-success bg-gradient' ?> shadow-sm">
                                <?= $esgotado ? 'Esgotado' : 'Disponível' ?>
                            </span>
                        </div>

                        <div class="card-body pt-5">
                            <div class="text-muted small mb-1"><?= $livro['categoria'] ?></div>
                            <h5 class="card-title text-dark fw-bold mb-0"><?= $livro['titulo'] ?></h5>
                            <p class="text-primary small mb-3"><?= $livro['nome_autor'] ?></p>

                            <div class="border-top pt-3 mt-3">
                                <div class="row text-center g-0">
                                    <div class="col border-end">
                                        <div class="small text-muted">Total</div>
                                        <div class="fw-bold"><?= $livro['quantidade'] ?></div>
                                    </div>
                                    <div class="col border-end">
                                        <div class="small text-muted">Saíram</div>
                                        <div class="fw-bold text-warning"><?= $livro['total_emprestados'] ?></div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Restam</div>
                                        <div class="fw-bold <?= $disponiveis > 0 ? 'text-success' : 'text-danger' ?>">
                                            <?= $disponiveis ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer bg-white border-0 pb-3">
                            <?php if (!$esgotado): ?>
                                <button class="btn btn-primary w-100 py-2"
                                    onclick="abrirModal(<?= $livro['id_livro'] ?>, '<?= addslashes($livro['titulo']) ?>')">
                                    <i class="fas fa-plus me-2"></i>Emprestar
                                </button>
                            <?php else: ?>
                                <button class="btn btn-secondary w-100 py-2" disabled>
                                    Indisponível
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </main>

    <!-- MODAL -->
    <div id="modal" class="modal-container" style="display:none; position: fixed; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.7); z-index: 9999; align-items: center; justify-content: center;">

        <div class="bg-white p-4 rounded-4 shadow-lg text-center" style="max-width: 400px; width: 90%;">

            <div class="mb-3"><i class="fas fa-book-reader fa-3x text-primary"></i></div>

            <h4 id="modalTitulo" class="fw-bold"></h4>

            <p class="text-muted">Deseja registrar o empréstimo de um exemplar deste livro?</p>

            <div class="d-grid gap-2 d-md-flex justify-content-md-center mt-4">
                <button class="btn btn-success px-4" onclick="confirmarEmprestimo()">Confirmar</button>
                <button class="btn btn-light px-4" onclick="fecharModal()">Cancelar</button>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="../assets/JS/acervoFunci.js"></script>
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</body>

</html>