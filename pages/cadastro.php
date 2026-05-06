<?php
include("../config/verifica_funcionario.php");
include_once("../config/conexao.php");

// Autores
$autores = $conn->query("SELECT * FROM autores ORDER BY nome");

// Livros
$sqlBuscaLivros = "SELECT id_livro, titulo FROM livros ORDER BY titulo";
$livrosParaExcluir = $conn->query($sqlBuscaLivros);

if (!$livrosParaExcluir) {
    die("Erro na consulta de livros: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Cadastro - Biblioteca</title>

<!-- Bootstrap + Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">

<style>
body {
    background-color: #f8f9fa;
}

/* Sidebar */
.sidebar {
    height: 100vh;
    position: fixed;
    width: 240px;
    background: #0b1727;
    color: white;
}

.sidebar .nav-link {
    color: #cbd5e1;
}

.sidebar .nav-link:hover {
    background: rgba(255,255,255,0.05);
    color: #fff;
}

.sidebar .nav-link.active {
    background: #2c7be5;
    color: #fff;
}

/* Conteúdo */
.content {
    margin-left: 240px;
}

/* Cards */
.card {
    border: none;
    border-radius: 12px;
}

</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar p-3">
    <h4 class="text-white mb-4">Bibliotheca</h4>

    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="acervofuncionario.php">
                <i class="fas fa-book me-2"></i> Acervo
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="emprestimo_funcionario.php">
                <i class="fas fa-list me-2"></i> Empréstimos
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="#">
                <i class="fas fa-plus me-2"></i> Cadastro
            </a>
        </li>
    </ul>

    <div class="mt-4">
        <button onclick="window.location.href='../config/logout.php'" class="btn btn-outline-light w-100">
            Sair
        </button>
    </div>
</div>

<!-- CONTEÚDO -->
<div class="content p-4">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Cadastro</h2>
    </div>

    <div class="row g-4">

        <!-- NOVO AUTOR -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Novo Autor</h5>

                    <form method="POST" action="../config/salvar_autor.php">
                        <input class="form-control mb-3" type="text" name="nome" placeholder="Nome do Autor" required>
                        <input class="form-control mb-3" type="text" name="nacionalidade" placeholder="Nacionalidade" required>

                        <button class="btn btn-primary w-100">Cadastrar Autor</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- NOVO LIVRO -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Novo Livro</h5>

                    <form method="POST" action="../config/salvar_livro.php">
                        <input class="form-control mb-3" type="text" name="titulo" placeholder="Título do Livro" required>
                        <input class="form-control mb-3" type="number" name="ano" placeholder="Ano de Publicação" required>
                        <input class="form-control mb-3" type="number" name="quantidade" min="1" value="1">

                        <select class="form-select mb-3" name="id_autor" required>
                            <option value="">Selecione um autor</option>
                            <?php while ($autor = $autores->fetch_assoc()): ?>
                                <option value="<?= $autor['id_autor'] ?>">
                                    <?= $autor['nome'] ?>
                                </option>
                            <?php endwhile; ?>
                        </select>

                        <button class="btn btn-success w-100">Cadastrar Livro</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- REMOVER -->
        <div class="col-12">
            <div class="card shadow-sm border-danger">
                <div class="card-body">
                    <h5 class="card-title text-danger">Remover Registro</h5>

                    <input class="form-control mb-3" type="text" id="busca_item" list="lista_itens" placeholder="Digite o título do livro...">

                    <datalist id="lista_itens">
                        <?php
                        $livrosParaExcluir->data_seek(0);
                        while ($l = $livrosParaExcluir->fetch_assoc()):
                        ?>
                            <option data-id="<?= $l['id_livro'] ?>" value="<?= $l['titulo'] ?>">
                        <?php endwhile; ?>
                    </datalist>

                    <button onclick="executarExclusao()" class="btn btn-danger">
                        Excluir Livro
                    </button>

                    <p id="mensagem-retorno" class="mt-3 fw-bold"></p>
                </div>
            </div>
        </div>

    </div>
</div>

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
                msg.innerText = res;
            }
        });
    }
}
</script>

</body>
</html>