const offcanvas = document.getElementById('myOffcanvas');
const backdrop = document.getElementById('offcanvasBackdrop');

// Função única para abrir/fechar
function toggleOffcanvas() {
    const isOpen = offcanvas.classList.contains('show');

    if (!isOpen) {
        openMenu();
    } else {
        closeMenu();
    }
}

function openMenu() {
    offcanvas.classList.add('show');
    backdrop.classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closeMenu() {
    offcanvas.classList.remove('show');
    backdrop.classList.remove('show');
    document.body.style.overflow = '';
}

// Evento para fechar ao clicar fora (no backdrop)
backdrop.addEventListener('click', () => {
    closeMenu();
});

// Opcional: Fechar ao apertar a tecla "Esc"
document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && offcanvas.classList.contains('show')) {
        closeMenu();
    }
});