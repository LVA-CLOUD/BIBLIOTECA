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

    <link rel="stylesheet" href="../assets/css/style.css">
<<<<<<< Updated upstream
=======
    <link rel="stylesheet" href="../assets/css/logout.css">

>>>>>>> Stashed changes
</head>

<body>

    <div class="layout">

        <!-- 🏛️ SIDEBAR -->
        <aside class="sidebar">
            <h2>Biblioteca Atenas</h2>
            <nav>
                <a href="acervofuncionario.php">📚 Acervo</a>
                <a href="#">📋 Emprestimos</a>
                <a href="cadastro.php">➕ Cadastro</a>
<<<<<<< Updated upstream
=======

                <div class="logout">
                    <button onclick="window.location.href='../config/logout.php'" class="btn-logout-sidebar">Sair</button>
                </div>
>>>>>>> Stashed changes
            </nav>
        </aside>

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

    </div>

</body>

</html>