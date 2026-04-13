<?php
session_start();
include_once("./config/conexao.php");

if (!isset($_SESSION['id_regi'])) {
    die("Faça login");
}

$id_regi = $_SESSION['id_regi'];

$sql = "SELECT livros.titulo, livros.id_livro, emprestimos.data_emprestimo, emprestimos.data_devolucao
FROM emprestimos
INNER JOIN livros ON livros.id_livro = emprestimos.id_livro
WHERE emprestimos.id_regi = $id_regi";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Meus Empréstimos</title>

    <link rel="stylesheet" href="./assets/css/style.css">
</head>

<body>

<div class="layout">

    <!-- 🏛️ SIDEBAR -->
    <aside class="sidebar">
        <h2>Biblioteca Atenas</h2>
        <nav>
            <a href="./index.php">📚 Acervo</a>
            <a href="./pages/cadastro.php">➕ Cadastro</a>
            <a href="./meus_emprestimos.php">📋 Meus Empréstimos</a>
        </nav>
    </aside>

    <!-- 📖 CONTEÚDO -->
    <main class="content">

        <header class="header">
            <h1>Meus Empréstimos</h1>
        </header>

        <section class="card">

            <table class="tabela">
                <tr>
                    <th>Livro</th>
                    <th>Empréstimo</th>
                    <th>Devolução</th>
                    <th>Status</th>
                    <th>Ação</th>
                </tr>

                <?php while($row = $result->fetch_assoc()): 
                    $atrasado = strtotime($row['data_devolucao']) < time();
                ?>

                <tr>
                    <td><?= $row['titulo'] ?></td>
                    <td><?= $row['data_emprestimo'] ?></td>
                    <td><?= $row['data_devolucao'] ?></td>

                    <td>
                        <?= $atrasado ? "<span class='status atraso'>🔴 Atrasado</span>" : "<span class='status ok'>🟢 Em dia</span>" ?>
                    </td>

                    <td>
                        <a class="btn-devolver" href="./config/devolver.php?id_livro=<?= $row['id_livro'] ?>">
                            Devolver
                        </a>
                    </td>
                </tr>

                <?php endwhile; ?>

            </table>

        </section>

    </main>

</div>

</body>
</html>