<?php
include("../config/verifica_funcionario.php");
include_once("../config/conexao.php");

$id_livro = $_GET['id'] ?? null;
if (!$id_livro) { header("Location: editFunci.php"); exit; }

$livro = $conn->query("SELECT * FROM livros WHERE id_livro = $id_livro")->fetch_assoc();
$autores = $conn->query("SELECT * FROM autores ORDER BY nome");
$fotos = $conn->query("SELECT * FROM livros_imagens WHERE id_livro = $id_livro ORDER BY principal DESC");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editando: <?= $livro['titulo'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
    <style>
        .foto-card { width: 150px; margin: 10px; position: relative; border: 1px solid #ddd; padding: 5px; }
        .img-edit { width: 100%; height: 150px; object-fit: cover; }
        .principal { border: 2px solid #198754; }
    </style>
</head>
<body class="bg-light p-4">
    <div class="container bg-white p-4 shadow-sm rounded">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="fas fa-edit"></i> Editar Livro</h2>
            <a href="editFunci.php" class="btn btn-secondary">Voltar</a>
        </div>

        <form action="../config/processar_edit_livro.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_livro" value="<?= $id_livro ?>">
            <div class="row">
                <div class="col-md-8">
                    <label>Título do Livro</label>
                    <input type="text" name="titulo" class="form-control mb-3" value="<?= $livro['titulo'] ?>" required>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Ano</label>
                            <input type="number" name="ano_publicacao" class="form-control mb-3" value="<?= $livro['ano_publicacao'] ?>">
                        </div>
                        <div class="col-md-6">
                            <label>Quantidade em Estoque</label>
                            <input type="number" name="quantidade" class="form-control mb-3" value="<?= $livro['quantidade'] ?>">
                        </div>
                    </div>
                    <label>Autor</label>
                    <select name="id_autor" class="form-select mb-3">
                        <?php while ($a = $autores->fetch_assoc()): ?>
                            <option value="<?= $a['id_autor'] ?>" <?= $a['id_autor'] == $livro['id_autor'] ? 'selected' : '' ?>>
                                <?= $a['nome'] ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <div class="card p-3 border-danger">
                        <h5>Zona de Perigo</h5>
                        <button type="submit" name="delete_livro" class="btn btn-outline-danger w-100" onclick="return confirm('Excluir livro?')">Excluir Livro</button>
                    </div>
                </div>
            </div>

            <hr>
            <h4>Gerenciar Fotos</h4>
            <input type="file" name="fotos[]" class="form-control mb-3" multiple accept="image/*">

            <div class="d-flex flex-wrap border p-3 rounded bg-light">
                <?php if ($fotos->num_rows > 0): ?>
                    <?php while ($f = $fotos->fetch_assoc()): ?>
                        <div class="foto-card <?= $f['principal'] ? 'principal' : '' ?>">
                            <?php if ($f['principal']): ?>
                                <span class="badge bg-success">Principal</span>
                            <?php endif; ?>
                            
                            <!-- AJUSTE AQUI: Caminho direto do banco -->
                            <img src="../<?= $f['caminho'] ?>" class="img-edit">

                            <div class="mt-2 d-flex justify-content-between">
                                <a href="../config/foto_operacoes.php?op=main&id_foto=<?= $f['id_livro_img'] ?>&id_livro=<?= $id_livro ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-star"></i></a>
                                <a href="../config/foto_operacoes.php?op=del&id_foto=<?= $f['id_livro_img'] ?>&id_livro=<?= $id_livro ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Excluir foto?')"><i class="fas fa-trash"></i></a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="text-muted">Nenhuma foto cadastrada.</p>
                <?php endif; ?>
            </div>
            <button type="submit" name="update_livro" class="btn btn-primary btn-lg w-100 mt-4">Salvar Todas as Alterações</button>
        </form>
    </div>
</body>
</html>