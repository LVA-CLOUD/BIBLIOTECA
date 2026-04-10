<?php
include_once("conexao.php");

// 🔹 Buscar autores (para usar no select de livro)
$sqlAutores = "SELECT * FROM autores ORDER BY nome";
$autores = $conn->query($sqlAutores);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./css/style.css">
    <title>Cadastro - Biblioteca</title>

    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Libre+Baskerville&display=swap" rel="stylesheet">
</head>

<body>

<div class="layout">

    <!-- 🏛️ SIDEBAR -->
    <aside class="sidebar">
        <h2>Bibliotheca</h2>
        <nav>
            <a href="index.php">📚 Acervo</a>
            <a href="cadastro.php">➕ Cadastro</a>
        </nav>
    </aside>

    <!-- 📖 CONTEÚDO -->
    <main class="content">

        <header class="header">
            <h1>Cadastro</h1>
        </header>
                    <h2>Registrar Manuscrito</h2>



        <!-- 👤 CADASTRO AUTOR -->
        <section class="card">
            <h2>Novo Autor</h2>

            <form method="POST" action="salvar_autor.php" class="form">
                <input type="text" name="nome" placeholder="Nome do Autor" required>
                <input type="text" name="nacionalidade" placeholder="Nacionalidade" required>

                <button type="submit">Cadastrar Autor</button>
            </form>
        </section>

        <!-- 📚 CADASTRO LIVRO -->
        <section class="card">
            <h2>Novo Livro</h2>

            <form method="POST" action="salvar_livro.php" class="form">
                <input type="text" name="titulo" placeholder="Título do Livro" required>
                <input type="number" name="ano" placeholder="Ano de Publicação" required>

                <select name="id_autor" required>
                    <option value="">Selecione um autor</option>

                    <?php while($autor = $autores->fetch_assoc()): ?>
                        <option value="<?= $autor['id_autor'] ?>">
                            <?= $autor['nome'] ?>
                        </option>
                    <?php endwhile; ?>

                </select>

                <button type="submit">Cadastrar Livro</button>
            </form>
        </section>

    </main>

</div>

</body>
</html>