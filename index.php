<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livraria Athenas</title>
    <!-- CSS -->
    <link rel="stylesheet" href="./assets/css/index.css">
    <link rel="stylesheet" href="./assets/css/intro.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Playfair+Display:wght@400;700&family=EB+Garamond:wght@400;700&display=swap" rel="stylesheet">

</head>

<body>




    <div id="intro">
        <div class="gate-container">
            <div class="gate-left" id="gateLeft"></div>
            <div class="gate-right" id="gateRight"></div>
        </div>

        <div class="title" id="title">
            <h1>ATHENAS</h1>
            <p>Bem-vindo a grande BIBLIOTECA ATHENIENSE </p>
        </div>

        <button class="enter-btn" id="enterBtn" onclick="enterSite()">
            ENTRAR NA BIBLIOTECA
        </button>

        <canvas id="particles"></canvas>
    </div>




    <header class="bg-black text-white  border-bottom border-gold border-opacity-10">

        <nav>
            <img src="./assets/img/LOGOS/logo1.png" alt="Logo">

            <ul>
                <li>Inicio</li>
                <li>Sobre</li>
                <li>Livros</li>
                <li>Agendamento</li>
                <li>Contato</li>
                <a href="./pages/login.php">Login</a>
            </ul>

        </nav>

    </header>

    <main>
        <!-- Hero -->
        <section class="hero">

            <img src="./assets/img/mulherSentada.png" alt="">

            <div class="titulo">
                <h1 class="reveal-subtext">AthenaS</h1>
                <p class="reveal-subtext">Sua biblioteca clássica no mundo digital. <br> Explore o conhecimento dos antigos com a tecnologia do futuro.</p>
            </div>
        </section>
    </main>

    <!-- ====================== QUEM SOMOS (Alternado) ====================== -->
    <section class="quem-somos py-5" style="background: #0a0805;">
        <div class="container">

            <!-- BLOCO 1: Imagem Esquerda | Texto Direito -->
            <div class="row align-items-center bloco mb-5">
                <div class="col-lg-10 order-lg-1" data-aos="fade-right">
                    <img src="./assets/img/LOGOS/atenas.jpg"
                        class="img-fluid rounded shadow-lg"
                        alt="Atenas Antiga">
                </div>
                <div class="col-lg-10 text-white" data-aos="fade-right">
                    <h2 class="titulo-bloco text-gold">
                        O Legado de Atenas
                    </h2>
                    <p>
                        A <strong>Biblioteca Athenas</strong> foi inspirada na antiga cidade
                        de <strong>Atenas, na Grécia</strong>, conhecida como o berço da filosofia,
                        da inteligência e dos grandes pensadores da humanidade.
                    </p>
                    <p>
                        Foi nesse cenário que nomes como <strong>Sócrates, Platão e Aristóteles</strong>
                        transformaram o conhecimento em algo capaz de atravessar gerações.
                    </p>
                </div>
            </div>

            <!-- BLOCO 2: Texto Esquerda | Imagem Direita -->
            <div class="row align-items-center bloco">
                <div class="col-lg-6 text-white order-lg-1" data-aos="fade-left">
                    <h2 class="titulo-bloco text-gold">
                        Conhecimento que Inspira
                    </h2>
                    <p>
                        Mais do que uma biblioteca, este espaço representa aprendizado,
                        descoberta e evolução, mantendo viva a essência de Atenas:
                        um lugar onde ideias, livros e conhecimento transformam pessoas.
                    </p>
                    <p>
                        Cada ambiente foi pensado para incentivar a curiosidade,
                        a reflexão e o amor pela leitura.
                    </p>
                </div>
                <div class="col-lg-6 order-lg-2" data-aos="fade-right">
                    <img src="./assets/img/LOGOS/atenasantigamente.jpg"
                        class="img-fluid rounded shadow-lg"
                        alt="Atenas Antiga">
                </div>
            </div>

        </div>
    </section>

    <!-- ====================== SOBRE A BIBLIOTECA ====================== -->
    <section class="sobre-biblioteca py-5" style="background: #0f0c08;">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="titulo-bloco text-white" style="color: var(--gold);">Sobre a Biblioteca Athenas</h2>
                <p class="text-white-50 fs-5">Conheça nossa história, missão e como funcionamos</p>
            </div>

            <div class="row g-5">
                <!-- História -->
                <div class="col-lg-4">
                    <div class="card h-100 bg-dark text-white border-0 shadow-lg" style="background: linear-gradient(#1c160f, #0a0805);">
                        <div class="card-body p-4">
                            <h4 class="text-gold mb-3">📜 Nossa História</h4>
                            <p>A Biblioteca Athenas nasceu da paixão pelo conhecimento clássico e pela preservação da sabedoria antiga. Inspirada na gloriosa <strong>Atenas Antiga</strong> — berço da filosofia ocidental, da democracia e dos grandes pensadores como Sócrates, Platão e Aristóteles —, buscamos recriar aquele espírito de curiosidade e debate em formato digital.</p>
                        </div>
                    </div>
                </div>

                <!-- Como Funciona -->
                <div class="col-lg-4">
                    <div class="card h-100 bg-dark text-white border-0 shadow-lg" style="background: linear-gradient(#1c160f, #0a0805);">
                        <div class="card-body p-4">
                            <h4 class="text-gold mb-3">⚙️ Como Funciona</h4>
                            <ul class="list-unstyled">
                                <li class="mb-3"><strong>1.</strong> Navegue por nossa coleção digital e física</li>
                                <li class="mb-3"><strong>2.</strong> Faça login para acessar recursos exclusivos</li>
                                <li class="mb-3"><strong>3.</strong> Agende o empréstimo de livros por até <strong>10 dias</strong></li>
                                <li class="mb-3"><strong>4.</strong> Leia online ou retire na unidade física</li>
                                <li><strong>5.</strong> Participe de eventos, debates e leituras coletivas</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Legado de Atenas -->
                <div class="col-lg-4">
                    <div class="card h-100 bg-dark text-white border-0 shadow-lg" style="background: linear-gradient(#1c160f, #0a0805);">
                        <div class="card-body p-4">
                            <h4 class="text-gold mb-3">🏛️ O Espírito de Atenas</h4>
                            <p>Atenas não era apenas uma cidade — era um ideal. Um lugar onde o pensamento crítico, a arte e a ciência floresceram. Aqui na Athenas Digital, mantemos esse fogo aceso:</p>
                            <ul class="list-unstyled mt-3">
                                <li>✔ Filosofia e Pensamento Crítico</li>
                                <li>✔ Literatura Clássica e Contemporânea</li>
                                <li>✔ História, Arte e Cultura</li>
                                <li>✔ Debates e Eventos Culturais</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ====================== NOSSOS LIVROS ====================== -->
    <section class="livros py-5" style="background: #000;">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="titulo-bloco text-white">Livros em Destaque</h2>
                <p class="text-white-50">Seleção especial da nossa coleção</p>
            </div>

            <div class="row g-4" id="livros-container">
                <!-- Cards serão gerados dinamicamente ou colocados manualmente -->

                <!-- Exemplo de Card 1 -->
                <div class="col-md-6 col-lg-3">
                    <div class="card livro-card h-100 bg-dark text-white border-0 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1544947958-8d3f2c0f6f3e?q=80&w=800" class="card-img-top" alt="A República">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">A República</h5>
                            <p class="card-text text-white-50 small">Platão</p>
                            <span class="badge bg-warning text-dark mb-3">ID: <strong>001</strong></span>
                            <a href="#" class="btn btn-outline-gold mt-auto">Ver Detalhes</a>
                        </div>
                    </div>
                </div>

                <!-- Exemplo de Card 2 -->
                <div class="col-md-6 col-lg-3">
                    <div class="card livro-card h-100 bg-dark text-white border-0 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1589829085413-56de8ae18c73?q=80&w=800" class="card-img-top" alt="Poética">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">Poética</h5>
                            <p class="card-text text-white-50 small">Aristóteles</p>
                            <span class="badge bg-warning text-dark mb-3">ID: <strong>042</strong></span>
                            <a href="#" class="btn btn-outline-gold mt-auto">Ver Detalhes</a>
                        </div>
                    </div>
                </div>

                <!-- Exemplo de Card 3 -->
                <div class="col-md-6 col-lg-3">
                    <div class="card livro-card h-100 bg-dark text-white border-0 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1497633762265-9d179a990aa6?q=80&w=800" class="card-img-top" alt="Odisseia">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">Odisseia</h5>
                            <p class="card-text text-white-50 small">Homero</p>
                            <span class="badge bg-warning text-dark mb-3">ID: <strong>127</strong></span>
                            <a href="#" class="btn btn-outline-gold mt-auto">Ver Detalhes</a>
                        </div>
                    </div>
                </div>

                <!-- Exemplo de Card 4 -->
                <div class="col-md-6 col-lg-3">
                    <div class="card livro-card h-100 bg-dark text-white border-0 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1532012197267-da84d127e765?q=80&w=800" class="card-img-top" alt="Meditações">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">Meditações</h5>
                            <p class="card-text text-white-50 small">Marco Aurélio</p>
                            <span class="badge bg-warning text-dark mb-3">ID: <strong>089</strong></span>
                            <a href="#" class="btn btn-outline-gold mt-auto">Ver Detalhes</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5">
                <a href="./pages/livros.php" class="btn btn-lg btn-outline-gold">Ver Todos os Livros</a>
            </div>
        </div>
    </section>

    <!-- ====================== AGENDAMENTO ====================== -->
    <section class="agendamento py-5" style="background: linear-gradient(#1c160f, #000);">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h2 class="titulo-bloco text-white mb-4">Agende sua Leitura</h2>
                    <p class="text-white-50 lead">Reserve o livro desejado por até <strong>10 dias</strong> e garanta seu acesso.</p>

                    <div class="mt-4">
                        <div class="d-flex align-items-center mb-3">
                            <span class="bg-gold text-dark rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px; font-size: 1.4rem;">📅</span>
                            <div class="ms-3">
                                <strong>Prazo de 10 dias</strong><br>
                                <span class="text-white-50">Leitura online ou retirada presencial</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <span class="bg-gold text-dark rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px; font-size: 1.4rem;">🔄</span>
                            <div class="ms-3">
                                <strong>Renovação automática</strong><br>
                                <span class="text-white-50">Caso o livro não esteja reservado por outro leitor</span>
                            </div>
                        </div>
                    </div>

                    <a href="./pages/agendamento.php" class="btn btn-gold btn-lg mt-4">Fazer Agendamento Agora</a>
                </div>

                <div class="col-lg-6 mt-5 mt-lg-0">
                    <div class="p-4 bg-black rounded-3 border border-gold border-opacity-25">
                        <h5 class="text-gold mb-3">Como agendar:</h5>
                        <ol class="text-white-50">
                            <li class="mb-2">Escolha o livro desejado</li>
                            <li class="mb-2">Faça login na sua conta</li>
                            <li class="mb-2">Selecione o período (máx. 10 dias)</li>
                            <li>Confirme o agendamento</li>
                        </ol>
                        <small class="text-warning">* Disponibilidade sujeita a consulta</small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ====================== RODAPÉ ====================== -->
    <footer class="bg-black text-white py-5 border-top border-gold border-opacity-10">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5 class="text-gold">Biblioteca Athenas</h5>
                    <p class="small text-white-50">Preservando o legado clássico para as novas gerações.</p>
                    <img src="./assets/img/LOGOS/logo1.png" alt="Logo" style="max-height: 60px; opacity: 0.9;">
                </div>

                <div class="col-md-4 mb-4">
                    <h5 class="text-gold">Contato</h5>
                    <ul class="list-unstyled small">
                        <li class="mb-2">📧 <a href="mailto:contato@bibliotecaathenas.com" class="text-white-50">contato@bibliotecaathenas.com</a></li>
                        <li class="mb-2">📱 <a href="https://wa.me/5511999999999" target="_blank" class="text-white-50">(11) 99999-9999</a></li>
                        <li class="mb-2">📍 Rua da Filosofia, 42 - São Paulo, SP</li>
                    </ul>
                </div>

                <div class="col-md-4 mb-4">
                    <h5 class="text-gold">Links Rápidos</h5>
                    <ul class="list-unstyled small">
                        <li><a href="#" class="text-white-50">Catálogo Completo</a></li>
                        <li><a href="#" class="text-white-50">Eventos e Debates</a></li>
                        <li><a href="./pages/login.php" class="text-white-50">Área do Leitor</a></li>
                        <li><a href="#" class="text-white-50">Política de Privacidade</a></li>
                    </ul>
                </div>
            </div>

            <hr class="border-gold border-opacity-10">
            <div class="text-center small text-white-50">
                © 2026 Biblioteca Athenas - Todos os direitos reservados.
            </div>
        </div>
    </footer>

    <style>
        .text-gold {
            color: var(--gold) !important;
        }

        .btn-gold {
            background: var(--gold);
            color: #000;
            font-weight: 600;
            letter-spacing: 2px;
        }

        .btn-outline-gold {
            border: 2px solid var(--gold);
            color: var(--gold);
        }

        .btn-outline-gold:hover {
            background: var(--gold);
            color: #000;
        }

        .livro-card {
            transition: all 0.4s;
        }

        .livro-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(212, 175, 55, 0.2) !important;
        }
    </style>

    <script>
        // Você pode adicionar aqui scripts adicionais para os novos cards se quiser carregar via JS do banco
    </script>

    <script src=" https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <script src="./assets/JS/index.js"></script>

</body>

</html>