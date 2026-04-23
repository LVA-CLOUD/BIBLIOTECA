let livroSelecionado = null;

function abrirModal(id, titulo) {
    livroSelecionado = id;
    document.getElementById('modalTitulo').innerText = titulo;
    document.getElementById('modal').style.display = 'flex';
}

function fecharModal() {
    document.getElementById('modal').style.display = 'none';
}

// Função para mostrar o Toast
function showToast(mensagem) {
    const toast = document.getElementById('toast');
    const toastMsg = document.getElementById('toast-message');
    
    toastMsg.innerText = mensagem;
    toast.classList.add('show');

    // Esconde automaticamente após 4 segundos
    setTimeout(() => {
        hideToast();
    }, 4000);
}

function hideToast() {
    const toast = document.getElementById('toast');
    toast.classList.remove('show');
}

function confirmarEmprestimo() {
    if (!livroSelecionado) {
        showToast("Erro: nenhum livro selecionado");
        return;
    }

    // Se você quer que o toast apareça ANTES de mudar de página (opcional):
    showToast("Processando empréstimo...");

    // Redireciona para o PHP
    setTimeout(() => {
        window.location.href = "../config/solicitar_emprestimo.php?id_livro=" + livroSelecionado;
    }, 1000); 
}

// Lógica extra: Se o PHP voltar com um parâmetro de sucesso na URL
window.onload = function() {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('sucesso')) {
        showToast("Empréstimo realizado com sucesso!");
    }
};