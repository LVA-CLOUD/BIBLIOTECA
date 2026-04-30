<?php
include("../config/verifica_funcionario.php");
include_once("../config/conexao.php");


// 🔹 Buscar autores (para usar no select de livro)
$sqlAutores = "SELECT * FROM autores ORDER BY nome";
$autores = $conn->query($sqlAutores);

?>



<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/cadastro.css">
    <link rel="stylesheet" href="../assets/css/logout.css">
    <title>Cadastro - Biblioteca</title>

    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Libre+Baskerville&display=swap" rel="stylesheet">
</head>

<body>
    <!-- Notificação Toast -->
    <div id="toast-container" class="toast-container"></div>

    <div class="layout">

        <!-- 🏛️ SIDEBAR -->
        <aside class="sidebar">
            <h2>Bibliotheca</h2>
            <nav>
                <a href="acervofuncionario.php">📚 Acervo</a>
                <a href="emprestimo_funcionario.php">📋 Emprestimos</a>
                <a href="#">➕ Cadastro</a>
<<<<<<< Updated upstream
=======


                <div class="logout">
                    <button onclick="window.location.href='../config/logout.php'" class="btn-logout-sidebar">Sair</button>
                </div>
>>>>>>> Stashed changes
            </nav>

            <div class="logout">
                <button onclick="window.location.href='../config/logout.php'" class="btn-logout-sidebar">Sair</button>
            </div>
        </aside>

        <!-- 📖 CONTEÚDO -->
        <main class="content">

            <header class="header">
                <h1>Cadastro</h1>
            </header>

            <h2>Registrar Manuscrito</h2>


            <section class="card">
                <h2>Novo Autor</h2>

                <form method="POST" action="../config/salvar_autor.php" class="form">
                    <input type="text" name="nome" placeholder="Nome do Autor" required>
                    <input type="text" name="nacionalidade" placeholder="Nacionalidade" required>

                    <button type="submit">Cadastrar Autor</button>
                </form>
            </section>

            <section class="card">
                <h2>Novo Livro</h2>

                <form method="POST" action="../config/salvar_livro.php" class="form">
                    <input type="text" name="titulo" placeholder="Título do Livro" required>
                    <input type="number" name="ano" placeholder="Ano de Publicação" required>

                    <select name="id_autor" required>
                        <option value="">Selecione um autor</option>
                        <?php while ($autor = $autores->fetch_assoc()): ?>
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


    <script src="../assets/JS/cadastro.js"></script>
</body>

</html>