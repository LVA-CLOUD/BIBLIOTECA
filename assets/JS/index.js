// Carragar sinopse ao clicar
function abrirSinopse(titulo, sinopse) {
            const modal = document.getElementById('modal-sinopse');
            document.getElementById('modal-titulo').innerText = titulo;
            document.getElementById('modal-texto').innerText = sinopse;

            modal.style.display = 'flex';
        }

        function fecharModal() {
            document.getElementById('modal-sinopse').style.display = 'none';
        }

        // Fechar se apertar Esc
        window.addEventListener('keydown', (e) => {
            if (e.key === "Escape") fecharModal();
        });