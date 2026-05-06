
// Função para exibir o toast
function showToast(message, type = 'success') {
    const container = document.getElementById('toast-container');

    // Criar o elemento do toast
    const toast = document.createElement('div');
    toast.classList.add('toast', type);
    toast.innerHTML = `
            <span>${message}</span>
            <span style="margin-left: 15px; cursor: pointer; font-weight: bold;" onclick="this.parentElement.remove()">×</span>
        `;

    container.appendChild(toast);

    // Remover automaticamente após 4 segundos
    setTimeout(() => {
        toast.classList.add('fade-out');
        setTimeout(() => { toast.remove(); }, 500);
    }, 4000);
}

// Verificar se existem parâmetros de status na URL ao carregar a página
window.onload = function () {
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');
    const msg = urlParams.get('msg');

    if (status && msg) {
        showToast(msg, status);

        // Limpa a URL para não repetir o toast se o usuário der F5
        window.history.replaceState({}, document.title, window.location.pathname);
    }
}


// Função para executar a exclusão do livro
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


// Upload

document.getElementById('inputImagens').addEventListener('change', function () {
    const container = document.getElementById('preview-container');
    container.innerHTML = ''; // Limpa o preview anterior

    if (this.files) {
        Array.from(this.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function (e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.width = '80px';
                img.style.height = '110px';
                img.style.objectFit = 'cover';
                img.classList.add('rounded', 'border');
                container.appendChild(img);
            }
            reader.readAsDataURL(file);
        });
    }
});