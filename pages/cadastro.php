<?php
include("../config/verifica_funcionario.php");
include_once("../config/conexao.php");

// 1. Buscar autores para o select de "Novo Livro" e para o datalist de autores
$autores = $conn->query("SELECT * FROM autores ORDER BY nome");

// 2. BUSCA DOS LIVROS (Essa é a parte que estava faltando para definir a variável)
$sqlBuscaLivros = "SELECT id_livro, titulo FROM livros ORDER BY titulo";
$livrosParaExcluir = $conn->query($sqlBuscaLivros);

// Verificar se a consulta falhou para evitar erros de objeto nulo
if (!$livrosParaExcluir) {
    die("Erro na consulta de livros: " . $conn->error);
}
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


                <div class="logout">
                    <button onclick="window.location.href='../config/logout.php'" class="btn-logout-sidebar">Sair</button>
                </div>
            </nav>
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

                    <input type="number" name="quantidade" placeholder="Quantidade em Estoque" min="1" value="1" required>

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

            <section class="card">
                <h2>Remover Registro</h2>
                <div class="form">
                    <input type="text" id="busca_item" list="lista_itens" placeholder="Digite o título do livro...">
                    <datalist id="lista_itens">
                        <?php
                        $livrosParaExcluir->data_seek(0);
                        while ($l = $livrosParaExcluir->fetch_assoc()):
                        ?>
                            <option data-id="<?= $l['id_livro'] ?>" value="<?= $l['titulo'] ?>">
                            <?php endwhile; ?>
                    </datalist>

                    <button type="button" onclick="executarExclusao()" class="btn-excluir" style="background-color: #d9534f; margin-top: 10px;">
                        Confirmar Exclusão
                    </button>
                    <!-- Local para mensagens de erro ou sucesso -->
                    <p id="mensagem-retorno" style="margin-top: 10px; font-weight: bold;"></p>
                </div>
            </section>
        </main>

    </div>


    <script src="../assets/JS/cadastro.js"></script>

    <script>
        function executarExclusao() {
            const input = document.getElementById('busca_item');
            const msg = document.getElementById('mensagem-retorno');
            const datalist = document.getElementById('lista_itens');
            const opcao = Array.from(datalist.options).find(opt => opt.value === input.value);

            if (!opcao) {
                msg.style.color = "orange";
                msg.innerText = "Selecione um livro da lista.";
                return;
            }

            if (confirm(`Excluir "${input.value}" permanentemente?`)) {
                const formData = new FormData();
                formData.append('id_livro', opcao.getAttribute('data-id'));

                fetch('../config/excluir_livro.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.text())
                    .then(res => {
                        if (res.trim() === "sucesso") {
                            msg.style.color = "green";
                            msg.innerText = "Livro removido com sucesso!";
                            setTimeout(() => location.reload(), 1500);
                        } else {
                            msg.style.color = "red";
                            // Aqui ele vai mostrar se há vínculo com empréstimos
                            msg.innerText = res;
                        }
                    });
            }
        }
    </script>
</body>

</html>