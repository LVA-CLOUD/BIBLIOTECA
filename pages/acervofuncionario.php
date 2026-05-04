<?php
include("../config/verifica_funcionario.php");
include_once("../config/conexao.php");

$idAutor = filter_input(INPUT_GET, 'autor', FILTER_VALIDATE_INT);
$categoria = $_GET['categoria'] ?? null;
$pesquisa = $_GET['pesquisa'] ?? null;

//BUSCA DE AUTORES
$sqlAutores = "SELECT id_autor, nome FROM autores ORDER BY nome";
$autores = $conn->query($sqlAutores);

//BUSCA DE LIVROS
$sqlLivros = "SELECT l.id_livro, l.titulo, l.ano_publicacao, l.categoria, a.nome as nome_autor,
                     e.id_livro AS emprestado, e.data_devolucao
              FROM livros l
              INNER JOIN autores a ON l.id_autor = a.id_autor
              LEFT JOIN emprestimos e ON l.id_livro = e.id_livro 
              AND e.data_devolucao >= CURDATE()";

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

// Preparar e executar a busca de livros
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

    <title>Biblioteca Imperial</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/modal.css">
    <link rel="stylesheet" href="../assets/css/logout.css">
</head>

<body>

    <?php if (isset($_GET['sucesso'])): ?>
        <div class="alerta">📚 Livro emprestado com sucesso!</div>
    <?php endif; ?>

    <div class="layout">

        <aside class="sidebar">
            <h2>Biblioteca Atenas</h2>
            <nav>
                <a href="#">📚 Acervo</a>
                <a href="emprestimo_funcionario.php">📋 Emprestimos</a>
                <a href="cadastro.php">➕ Cadastro</a>

                <div class="logout">
                    <button onclick="window.location.href='../config/logout.php'" class="btn-logout-sidebar">Sair</button>
                </div>
            </nav>
        </aside>

        <main class="content">

            <header class="header">
                <h1>Biblioteca Imperial de Atenas</h1>
            </header>

            <!-- FILTRO -->
            <section class="card">
                <h2>Filtrar</h2>

                <form method="GET" class="form filtro-flex">

                    <input type="text" name="pesquisa" placeholder="Pesquisar..."
                        value="<?= isset($_GET['pesquisa']) ? $_GET['pesquisa'] : '' ?>">

                    <select name="autor">
                        <option value="">Autores</option>
                        <?php
                        $autores->data_seek(0);
                        while ($autor = $autores->fetch_assoc()):
                        ?>
                            <option value="<?= $autor['id_autor'] ?>" <?= ($idAutor == $autor['id_autor']) ? 'selected' : '' ?>>
                                <?= $autor['nome'] ?>
                            </option>
                        <?php endwhile; ?>
                    </select>

                    <select name="categoria">
                        <option value="">Categorias</option>
                        <option value="Terror" <?= ($categoria == "Terror") ? 'selected' : '' ?>>Terror</option>
                        <option value="Romance" <?= ($categoria == "Romance") ? 'selected' : '' ?>>Romance</option>
                        <option value="Suspense" <?= ($categoria == "Suspense") ? 'selected' : '' ?>>Suspense</option>
                        <option value="Ficção" <?= ($categoria == "Ficção") ? 'selected' : '' ?>>Ficção</option>
                    </select>

                    <button type="submit">Filtrar</button>
                </form>
            </section>

            <!-- LIVROS -->
            <section class="card">
                <h2>Acervo</h2>

                <div class="grid-livros">

                    <?php while ($livro = $result->fetch_assoc()): ?>

                        <div class="livro <?= $livro['emprestado'] ? 'bloqueado' : '' ?>"
                            <?= !$livro['emprestado'] ? "onclick=\"abrirModal({$livro['id_livro']}, '" . addslashes($livro['titulo']) . "')\"" : '' ?>>

                            <h3><?= ($livro['titulo']) ?></h3>
                            <p><?= $livro['ano_publicacao'] ?></p>
                            <span><?= $livro['nome_autor'] ?></span>

                            <?php if ($livro['emprestado']): ?>
                                <p class="indisponivel">Indisponível até <?= $livro['data_devolucao'] ?></p>
                            <?php endif; ?>

                        </div>

                    <?php endwhile; ?>

                </div>
            </section>

        </main>
    </div>

    <!-- MODAL -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <h3 id="modalTitulo"></h3>
            <p>Você gostaria do empréstimo deste livro?</p>
            <button onclick="confirmarEmprestimo()">Sim</button>
            <button onclick="fecharModal()">Não</button>
        </div>
    </div>

    <script>
        let livroSelecionado = null;

        function abrirModal(id, titulo) {
            livroSelecionado = id;

            document.getElementById('modalTitulo').innerText = titulo;
            document.getElementById('modal').style.display = 'flex';
        }

        function fecharModal() {
            document.getElementById('modal').style.display = 'none';
        }

        function confirmarEmprestimo() {
            if (!livroSelecionado) {
                alert("Erro: nenhum livro selecionado");
                return;
            }

            // redireciona para o PHP que faz o empréstimo
            window.location.href = "emprestar.php?id_livro=" + livroSelecionado;
        }
    </script>
</body>

</html>