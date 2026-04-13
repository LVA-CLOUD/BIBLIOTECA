const form = document.getElementById('formLivro');
const lista = document.getElementById('listaLivros');

// Função para buscar livros no PHP
async function carregarLivros() {
    const resp = await fetch('api.php');
    const livros = await resp.json();
    lista.innerHTML = livros.map(l => `<li>${l.titulo} (${l.ano_publicacao})</li>`).join('');
}

// Enviar dados para o PHP
form.onsubmit = async (e) => {
    e.preventDefault();
    const dados = new FormData();
    dados.append('titulo', document.getElementById('titulo').value);
    dados.append('ano', document.getElementById('ano').value);

    await fetch('api.php', { method: 'POST', body: dados });
    form.reset();
    carregarLivros();
};

carregarLivros();

function abrirModal(id, titulo) {
    livroSelecionado = id;

    const modal = document.getElementById('modal');
    const tituloEl = document.getElementById('modalTitulo');

    if (!modal || !tituloEl) {
        console.error("Modal não encontrado");
        return;
    }

    tituloEl.innerText = titulo;
    modal.style.display = 'flex';
}