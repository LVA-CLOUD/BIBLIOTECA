<?php
include("./config/verifica_funcionario.php");
include_once("./config/conexao.php");

$idAutor = isset($_GET['autor']) ? (int) $_GET['autor'] : null;
$categoria = isset($_GET['categoria']) ? $_GET['categoria'] : null;
$pesquisa = isset($_GET['pesquisa']) ? $conn->real_escape_string($_GET['pesquisa']) : null;

// 🔹 AUTORES
$sqlAutores = "SELECT * FROM autores ORDER BY nome";
$autores = $conn->query($sqlAutores);

// 🔹 LIVROS (COM BLOQUEIO DE EMPRÉSTIMO)
$sqlLivros = "SELECT livros.id_livro, livros.titulo, livros.ano_publicacao, livros.categoria, autores.nome,
              emprestimos.id_livro AS emprestado, emprestimos.data_devolucao
              FROM livros
              INNER JOIN autores ON livros.id_autor = autores.id_autor
              LEFT JOIN emprestimos ON livros.id_livro = emprestimos.id_livro
              AND emprestimos.data_devolucao >= CURDATE()";

// filtros
$condicoes = [];

if ($idAutor) {
    $condicoes[] = "autores.id_autor = $idAutor";
}

if (!empty($categoria)) {
    $condicoes[] = "livros.categoria = '$categoria'";
}

if (!empty($pesquisa)) {
    $condicoes[] = "(livros.titulo LIKE '%$pesquisa%' OR autores.nome LIKE '%$pesquisa%')";
}

if (count($condicoes) > 0) {
    $sqlLivros .= " WHERE " . implode(" AND ", $condicoes);
}

$result = $conn->query($sqlLivros);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Biblioteca Imperial</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/modal.css">
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
                <a href="meus_emprestimos.php">📋 Meus Empréstimos</a>
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

                            <h3><?= $livro['titulo'] ?></h3>
                            <p><?= $livro['ano_publicacao'] ?></p>
                            <span><?= $livro['nome'] ?></span>

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