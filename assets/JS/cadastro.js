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
    window.onload = function() {
        const urlParams = new URLSearchParams(window.location.search);
        const status = urlParams.get('status');
        const msg = urlParams.get('msg');

        if (status && msg) {
            showToast(msg, status);
            
            // Limpa a URL para não repetir o toast se o usuário der F5
            window.history.replaceState({}, document.title, window.location.pathname);
        }
    }
