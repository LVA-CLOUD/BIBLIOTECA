<?php
include_once("../config/verifica_login.php");
include_once("../config/conexao.php");

$id_regi = $_SESSION['id_usuario'];

// Selecionamos as colunas necessárias, incluindo a data_emprestimo que estava faltando no seu SELECT
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
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Empréstimos</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/logout.css">

</head>

<body>

    <div class="layout">
        <aside class="sidebar">

            <h2>Biblioteca Atenas</h2>

            <nav>
                <a href="acervocliente.php">📚 Acervo</a>
                <a href="#">📋 Meus Empréstimos</a>
                <a href="inicio.php">Voltar</a>
            </nav>

        </aside>

        <main class="content">

            <header class="header">
                <h1>Meus Empréstimos</h1>
            </header>

            <section class="card">

                <table class="tabela">

                    <thead>
                        <tr>
                            <th>Livro</th>
                            <th>Empréstimo</th>
                            <th>Devolução</th>
                            <th>Status</th>
                            <th>Ação</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php while ($row = $result->fetch_assoc()):
                            $atrasado = (strtotime($row['data_devolucao']) < time() && $row['status'] == 'aprovado');
                        ?>
                            <tr>
                                <td><?= htmlspecialchars($row['titulo']) ?></td>
                                <td><?= date('d/m/Y', strtotime($row['data_emprestimo'])) ?></td>
                                <td><?= date('d/m/Y', strtotime($row['data_devolucao'])) ?></td>

                                <td>
                                    <?php
                                    if ($row['status'] == 'pendente') {
                                        echo "<span class='status pendente'>⏳ Aguardando</span>";
                                    } elseif ($row['status'] == 'aprovado') {
                                        echo $atrasado ? "<span class='status atraso'>🔴 Atrasado</span>" : "<span class='status ok'>🟢 Em dia</span>";
                                    } else {
                                        echo "<span class='status negado'>❌ Negado</span>";
                                    }
                                    ?>
                                </td>

                                <td>
                                    <?php if ($row['status'] == 'aprovado'): ?>
                                        <a class="btn-devolver" href="../config/devolver.php?id_livro=<?= $row['id_livro'] ?>">
                                            Devolver
                                        </a>
                                    <?php else: ?>
                                        ---
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>

                    </tbody>

                </table>

            </section>

        </main>

    </div>

</body>

</html>