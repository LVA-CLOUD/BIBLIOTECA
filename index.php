<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS -->
    <link rel="stylesheet" href="./assets/css/index.css">
    <link rel="stylesheet" href="./assets/css/swup.css">
    <title>Livraria Athenas</title>
</head>

<body>

    <header>

        <nav>
            <img src="./assets/img/LOGOS/logo1.png" alt="Logo">

            <ul>
                <li>Inicio</li>
                <li>Livros</li>
                <li>Contato</li>
                <li>Sobre</li>
                <a href="./pages/login.php">Login</a>
            </ul>

        </nav>

    </header>

    <main>
        <!-- Hero -->
        <section class="hero">

            <img src="./assets/img/mulherSentada.png" alt="">

            <div class="titulo">
                <h1>AthenaS</h1>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Illum dignissimos aliquid consequatur possimus eos temporibus expedita fugiat vitae beatae architecto? Temporibus quo dolore officiis natus dolores maiores perspiciatis asperiores doloribus!</p>
            </div>
        </section>

        <!-- Carrossel -->
        <section class="livros-carrossel">
            <div class="carrossel-track">
                <!-- Os itens se repetem para criar o efeito infinito -->
                <div class="livro-item" onclick="abrirSinopse('harry potter', 'A história de Bentinho e a dúvida eterna sobre Capitu.', './assets/img/livro1.jpg')">
                    <img src="./assets//img/LIVROS/horaEstrela.png" alt="Livro 1">
                </div>
                <div class="livro-item" onclick="abrirSinopse('1984', 'Um futuro distópico onde o Grande Irmão tudo vê.', './assets/img/livro2.jpg')">
                    <img src="./assets//img/LIVROS/picapauAmarelo.png" alt="Livro 2">
                </div>
                <div class="livro-item" onclick="abrirSinopse('O Hobbit', 'A aventura de Bilbo Bolseiro pela Terra Média.', './assets/img/livro3.jpg')">
                    <img src="./assets//img/LIVROS/Hobbit.png" alt="Livro 3">
                </div>
                <!-- Repita os itens para preencher o espaço e o loop ser invisível -->
                <div class="livro-item" onclick="abrirSinopse('Dom Casmurro', '...', './assets/img/livro1.jpg')">
                    <img src="./assets//img/LIVROS/livroVidasSecas.png" alt="Livro 1">
                </div>
                <div class="livro-item" onclick="abrirSinopse('Dom Casmurro', '...', './assets/img/livro1.jpg')">
                    <img src="./assets//img/LIVROS/livroVidasSecas.png" alt="Livro 1">
                </div>

                <div class="livro-item" onclick="abrirSinopse('Dom Casmurro', '...', './assets/img/livro1.jpg')">
                    <img src="./assets//img/LIVROS/livroVidasSecas.png" alt="Livro 1">
                </div>

                <div class="livro-item" onclick="abrirSinopse('Dom Casmurro', '...', './assets/img/livro1.jpg')">
                    <img src="./assets//img/LIVROS/livroVidasSecas.png" alt="Livro 1">
                </div>
                
                <div class="livro-item" onclick="abrirSinopse('Dom Casmurro', '...', './assets/img/livro1.jpg')">
                    <img src="./assets//img/LIVROS/livroVidasSecas.png" alt="Livro 1">
                </div>

                <div class="livro-item" onclick="abrirSinopse('Dom Casmurro', '...', './assets/img/livro1.jpg')">
                    <img src="./assets//img/LIVROS/livroVidasSecas.png" alt="Livro 1">
                </div>
                <div class="livro-item" onclick="abrirSinopse('Dom Casmurro', '...', './assets/img/livro1.jpg')">
                    <img src="./assets//img/LIVROS/livroVidasSecas.png" alt="Livro 1">
                </div>
                <div class="livro-item" onclick="abrirSinopse('Dom Casmurro', '...', './assets/img/livro1.jpg')">
                    <img src="./assets//img/LIVROS/livroVidasSecas.png" alt="Livro 1">
                </div>
                <div class="livro-item" onclick="abrirSinopse('Dom Casmurro', '...', './assets/img/livro1.jpg')">
                    <img src="./assets//img/LIVROS/livroVidasSecas.png" alt="Livro 1">
                </div>
                <div class="livro-item" onclick="abrirSinopse('Dom Casmurro', '...', './assets/img/livro1.jpg')">
                    <img src="./assets//img/LIVROS/livroVidasSecas.png" alt="Livro 1">
                </div>
                <div class="livro-item" onclick="abrirSinopse('Dom Casmurro', '...', './assets/img/livro1.jpg')">
                    <img src="./assets//img/LIVROS/livroVidasSecas.png" alt="Livro 1">
                </div>
                <div class="livro-item" onclick="abrirSinopse('Dom Casmurro', '...', './assets/img/livro1.jpg')">
                    <img src="./assets//img/LIVROS/livroVidasSecas.png" alt="Livro 1">
                </div>

                <div class="livro-item" onclick="abrirSinopse('Dom Casmurro', '...', './assets/img/livro1.jpg')">
                    <img src="./assets//img/LIVROS/livroVidasSecas.png" alt="Livro 1">
                </div>

                <div class="livro-item" onclick="abrirSinopse('Dom Casmurro', '...', './assets/img/livro1.jpg')">
                    <img src="./assets//img/LIVROS/livroVidasSecas.png" alt="Livro 1">
                </div>

                <div class="livro-item" onclick="abrirSinopse('Dom Casmurro', '...', './assets/img/livro1.jpg')">
                    <img src="./assets//img/LIVROS/livroVidasSecas.png" alt="Livro 1">
                </div>

                <div class="livro-item" onclick="abrirSinopse('Dom Casmurro', '...', './assets/img/livro1.jpg')">
                    <img src="./assets//img/LIVROS/livroVidasSecas.png" alt="Livro 1">
                </div>

                <div class="livro-item" onclick="abrirSinopse('Dom Casmurro', '...', './assets/img/livro1.jpg')">
                    <img src="./assets//img/LIVROS/livroVidasSecas.png" alt="Livro 1">
                </div>

                <div class="livro-item" onclick="abrirSinopse('Dom Casmurro', '...', './assets/img/livro1.jpg')">
                    <img src="./assets//img/LIVROS/livroVidasSecas.png" alt="Livro 1">
                </div>

                <div class="livro-item" onclick="abrirSinopse('Dom Casmurro', '...', './assets/img/livro1.jpg')">
                    <img src="./assets//img/LIVROS/livroVidasSecas.png" alt="Livro 1">
                </div>

                <div class="livro-item" onclick="abrirSinopse('1984', '...', './assets/img/livro2.jpg')">
                    <img src="./assets/img/livro2.jpg" alt="Livro 2">
                </div>
            </div>
        </section>

        <!-- Modal de Sinopse -->
        <div id="modal-sinopse" class="modal" onclick="fecharModal()">
            <div class="modal-content" onclick="event.stopPropagation()">
                <span class="close" onclick="fecharModal()">&times;</span>
                <h2 id="modal-titulo">Título do Livro</h2>
                <p id="modal-texto">Sinopse aqui...</p>
            </div>
        </div>

    </main>

    <script>
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
    </script>
</body>

</html>