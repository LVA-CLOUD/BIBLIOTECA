<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livraria Athenas</title>
    <!-- CSS -->
    <link rel="stylesheet" href="./assets/css/index.css">

</head>

<<body>

<!-- INTRO CINEMATOGRÁFICA -->

<div class="intro">

    <!-- SOM -->
    <audio id="doorSound" src="./assets/audio/door.mp3"></audio>

    <!-- CENA 3D -->
    <div class="scene">

        <!-- FUNDO -->
        <img src="./assets/img/partenon.png" class="partenon">

        <!-- ESCURIDÃO -->
        <div class="overlay"></div>

        <!-- NÉVOA -->
        <div class="fog"></div>

        <!-- PORTAS -->
        <div class="door left-door"></div>
        <div class="door right-door"></div>

    </div>

    <!-- TEXTO -->
    <div class="intro-logo">
        <h1>ATHENAS</h1>
        <p>O conhecimento atravessa séculos.</p>
    </div>

</div>

    <header>

        <nav>
            <img src="./assets/img/LOGOS/logo1.png" alt="Logo">

            <ul>
                <li>Inicio</li>
                <li>Sobre</li>
                <li>Livros</li>
                <li>Contato</li>
                <li>Agendamento</li>
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

    <section class="quem-somos py-5">
        <div class="container">

            <!-- BLOCO 1 -->
            <div class="row align-items-center bloco mb-5">

                <img src="./assets/img/LOGOS/atenas.jpg" class="imagem">

                <div class="col-md-6 text-white" data-aos="fade-left">

                    <h2 class="titulo-bloco">
                        O Legado de Atenas
                    </h2>

                    <p>
                        A <strong>Biblioteca Atenas</strong> foi inspirada na antiga cidade
                        de <strong>Atenas, na Grécia</strong>, conhecida como o berço da filosofia,
                        da inteligência e dos grandes pensadores da humanidade.
                    </p>

                    <p>
                        Foi nesse cenário que nomes como <strong>Sócrates, Platão e Aristóteles</strong>
                        transformaram o conhecimento em algo capaz de atravessar gerações.
                    </p>

                </div>
            </div>

            <!-- BLOCO 2 -->
            <div class="row align-items-center bloco">

                <div class="col-md-6 order-md-1 text-white" data-aos="fade-right">

                    <h2 class="titulo-bloco">
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

                <div class="col-md-6 order-md-2" data-aos="fade-left">

                    <img src="./assets/img/LOGOS/atenasantigamente.jpg"
                        class="img-fluid rounded shadow-lg imagem">

                </div>
            </div>

        </div>
    </section>
    <script src=" https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <script src="./assets/JS/index.js"></script>

    </body>

</html>