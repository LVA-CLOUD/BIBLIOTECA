// Preenche o formulário de autor ao selecionar no dropdown
function carregarDadosAutor(dadosRaw) {
    if (!dadosRaw) return;
    const dados = JSON.parse(dadosRaw);
    
    document.getElementById('edit_id_autor').value = dados.id_autor;
    document.getElementById('edit_nome_autor').value = dados.nome;
    document.getElementById('edit_nacionalidade').value = dados.nacionalidade;
}

// Redireciona para uma página específica de edição de livro
function abrirEdicaoLivro() {
    const input = document.getElementById('input_busca_livro');
    const list = document.getElementById('lista_livros');
    const option = Array.from(list.options).find(opt => opt.value === input.value);

    if (option) {
        const id = option.getAttribute('data-id');
        window.location.href = `editLivro.php?id=${id}`;
    } else {
        alert("Selecione um livro válido da lista.");
    }
}