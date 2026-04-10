<?php
include_once("conexao.php");

$idAutor = isset($_GET['autor']) ? (int) $_GET['autor'] : null;

// 🔹 AUTORES
$sqlAutores = "SELECT * FROM autores ORDER BY nome";
$autores = $conn->query($sqlAutores);

// 🔹 LIVROS
$sqlLivros = "SELECT livros.titulo, livros.ano_publicacao, autores.nome
              FROM livros
              INNER JOIN autores ON livros.id_autor = autores.id_autor";

if ($idAutor) {
    $sqlLivros .= " WHERE autores.id_autor = $idAutor";
}

$result = $conn->query($sqlLivros);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./css/style.css">
    <title>Biblioteca Imperial</title>

    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Libre+Baskerville&display=swap" rel="stylesheet">
</head>

<body>

<div class="layout">

    <!-- 🏛️ SIDEBAR -->
    <aside class="sidebar">
        <h2>Biblioteca atenas</h2>
        <nav>
            <a href="#">📚 Acervo</a>
            <a href="cadastro.php">➕ Cadastro</a>
        </nav>
    </aside>

    <!-- 📖 CONTEÚDO -->
    <main class="content">

        <header class="header">
            <h1>Biblioteca Imperial de Atenas</h1>
        </header>

        <!-- 📜 CADASTRO -->


        <!-- 🔎 FILTRO -->
        <section class="card">
            <h2>Filtrar por Autor</h2>

            <form method="GET" class="form">
                <select name="autor">
                    <option value="">Todos</option>

                    <?php
                    $autores->data_seek(0);
                    while($autor = $autores->fetch_assoc()):
                    ?>
                        <option value="<?= $autor['id_autor'] ?>"
                            <?= ($idAutor == $autor['id_autor']) ? 'selected' : '' ?>>
                            <?= $autor['nome'] ?>
                        </option>
                    <?php endwhile; ?>
                </select>

                <button type="submit">Filtrar</button>
            </form>
        </section>




        <!-- 📚 LISTA -->
        <section class="card">
            <h2>Acervo</h2>

            <div class="grid-livros">
                <?php while($livro = $result->fetch_assoc()): ?>
                    <div class="livro">
                        <h3><?= $livro['titulo'] ?></h3>
                        <p><?= $livro['ano_publicacao'] ?></p>
                        <span><?= $livro['nome'] ?></span>
                    </div>
                <?php endwhile; ?>
            </div>

        </section>

    </main>.

</div>

</body>
</html>