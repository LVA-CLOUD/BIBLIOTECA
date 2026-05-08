<?php
include("../config/verifica_funcionario.php");
include_once("../config/conexao.php");

// Busca Autores para o Select e Listagem
$autores = $conn->query("SELECT * FROM autores ORDER BY nome");

// Busca Livros para o Datalist de busca
$sqlBuscaLivros = "SELECT id_livro, titulo FROM livros ORDER BY titulo";
$livrosParaBusca = $conn->query($sqlBuscaLivros);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Acervo - Biblioteca Athenas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/cadastro.css">
</head>
<body>

<!-- SIDEBAR -->
    <div class="sidebar p-3">
        
        <div class="logo">
            <img src="../assets/img/LOGOS/logoAthenas.png" alt="">
        </div>

        <ul class="nav flex-column">

            <li class="nav-item">
                <a class="nav-link" href="dashboard.php">
                    <i class="fas fa-chart-pie"></i> Dashboard
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="acervofuncionario.php">
                    <i class="fas fa-book me-2"></i> Acervo
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="emprestimo_funcionario.php">
                    <i class="fas fa-exchange-alt me-2"></i> Empréstimos
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="cadastro.php">
                    <i class="fas fa-plus-circle me-2"></i> Cadastro
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link active" href="#">
                    <i class="fas fa-pen me-2"></i> Gerenciar
                </a>
            </li>
        </ul>

        <div class="row-sair"></div>

        <div class="mt-4">
            <button onclick="window.location.href='../config/logout.php'" class="btn w-100">
                Sair
            </button>
        </div>
    </div>

    <div class="content p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Gerenciar Autores e Livros</h2>
        </div>

        <div class="row g-4">
            <!-- EDITAR AUTOR -->
            <div class="col-md-6">
                <div class="card shadow-lg h-100">
                    <div class="card-body">
                        <h5 class="card-title text-primary"><i class="fas fa-user-edit"></i> Editar/Excluir Autor</h5>
                        <p class="small text-muted">Selecione um autor para carregar os dados</p>
                        
                        <select class="form-select mb-3" id="select_autor" onchange="carregarDadosAutor(this.value)">
                            <option value="">Selecione um autor...</option>
                            <?php while ($a = $autores->fetch_assoc()): ?>
                                <option value='<?= json_encode($a) ?>'><?= $a['nome'] ?></option>
                            <?php endwhile; ?>
                        </select>

                        <form method="POST" action="../config/atualizar_autor.php">
                            <input type="hidden" name="id_autor" id="edit_id_autor">
                            <input class="form-control mb-3" type="text" name="nome" id="edit_nome_autor" placeholder="Nome" required>
                            <input class="form-control mb-3" type="text" name="nacionalidade" id="edit_nacionalidade" placeholder="Nacionalidade" required>
                            
                            <div class="d-flex gap-2">
                                <button type="submit" name="action" value="update" class="btn btn-primary w-100">Salvar Alterações</button>
                                <button type="submit" name="action" value="delete" class="btn excluir btn-outline-danger" onclick="return confirm('Excluir este autor permanentemente?')">Excluir</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- LIVRO PARA EDIÇÃO -->
            <div class="col-md-6">
                <div class="card shadow-lg h-100">
                    <div class="card-body">
                        <h5 class="card-title text-primary"><i class="fas fa-book"></i> Editar/Excluir Livro</h5>
                        <p class="small text-muted">Busque pelo título para abrir a edição completa</p>
                        
                        <input class="form-control mb-3" list="lista_livros" id="input_busca_livro" placeholder="Digite o título...">
                        <datalist id="lista_livros">
                            <?php while ($l = $livrosParaBusca->fetch_assoc()): ?>
                                <option data-id="<?= $l['id_livro'] ?>" value="<?= $l['titulo'] ?>">
                            <?php endwhile; ?>
                        </datalist>

                        <button type="button" onclick="abrirEdicaoLivro()" class="btn btn-success w-100">Editar Livro Selecionado</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="../assets/JS/editFunci.js"></script>
</body>
</html>