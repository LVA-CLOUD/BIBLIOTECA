//  Função para abrir o modal de confirmação
let livroSelecionado = null;
function abrirModal(id, titulo) {
    livroSelecionado = id;
    document.getElementById('modalTitulo').innerText = titulo;
    document.getElementById('modal').style.display = 'flex';
}
function fecharModal() {
    document.getElementById('modal').style.display = 'none';
}
function confirmarEmprestimo() {
    if (livroSelecionado) {
        window.location.href = "emprestar.php?id_livro=" + livroSelecionado;
    }
}