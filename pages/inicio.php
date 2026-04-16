<?php
include("../config/verifica_login.php");
include("../config/conexao.php");

// Pegando o ID que está salvo na sessão
$id_logado = $_SESSION['id_usuario'];

// SELECT para buscar os dados desse ID específico
$sql_user = "SELECT user_regi FROM registro WHERE id_regi = ?";
$stmt = $conn->prepare($sql_user);
$stmt->bind_param("i", $id_logado);
$stmt->execute();
$resultado = $stmt->get_result();
$dados_usuario = $resultado->fetch_assoc();

// Para guardar o nome em uma variavel
$nome_exibicao = $dados_usuario['user_regi'];

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- BootsTrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <!-- CSS -->
    <link rel="stylesheet" href="../assets/css/inicio.css">
    <link rel="stylesheet" href="../assets/css/nav.css">

    <title>Atenas</title>
</head>

<body>
    <header>

        <nav>
            <ul>
                <li>Início</li>
                <li>Livros</li>
                <li>Agendamento</li>
                <li>Contato</li>
                <li><i class="bi bi-search"></i></li>

            </ul>
        </nav>

        <img src="../assets/img/LOGOS/logo1.png" alt="Logo">


        <!-- Offcanvas -->
        <div class="offoff">

            <button class="btn-open btn-icon" onclick="toggleOffcanvas()"><i class="bi bi-person-fill"></i></button>

            <div id="offcanvasBackdrop" class="offcanvas-backdrop" onclick="triggerStaticAnimation()"></div>

            <div id="myOffcanvas" class="offcanvas-container">

                <div class="offcanvas-header">

                    <h3>Olá, <?= htmlspecialchars($nome_exibicao); ?>!</h3>

                    <button class="btn-close" onclick="toggleOffcanvas()">&times;</button>
                </div>

                <div class="offcanvas-body">
                    <a href="meus_emprestimos.php">meus emprestimos</a>
                    <a href="#">Services</a>
                    <a href="#">Clients</a>
                    <a href="#">Contact</a>
                </div>

                <div class="logout">
                    <button onclick="window.location.href='../config/logout.php'" class="btn-logout-sidebar">Sair</button>
                </div>
            </div>
            </ul>
        </div>


    </header>

    <main>
        <section class="slider">

            <div class="slider-content ativo">
                <img class="AlgoRelacionado" src="../assets/img/LIVROS/livroVidasSecas2.png" alt="Vidas Secas">

                <div class="conteudo">
                    <h1>Vidas Secas</h1>
                    <p>"Vidas Secas" é a obra mais emblemática do escritor brasileiro moderno Graciliano Ramos (1892-1953). O livro foi publicado em 1938 e trata-se de um romance documental inspirado nas experiências do autor.
                        O local de desenvolvimento da estória é o sertão brasileiro nordestino, onde Graciliano Ramos retrata a vida de uma família de retirantes, traçando a figura do sertanejo. Ao mesmo tempo, ele explora os temas da miséria e da seca do Nordeste.</p>
                    <button>Adquira Agora</button>
                </div>

                <div class="livros">
                    <img src="../assets/img/LIVROS/livroVidasSecas.png" alt="Vidas Secas">
                    <img src="../assets/img/LIVROS/horaEstrela.png" alt="Hora Estrela">
                </div>
            </div>

            <div class="slider-content">
                <img class="AlgoRelacionado" src="../assets/img/LIVROS/horaEstrela2.png" alt="Hora Estrela">

                <div class="conteudo">
                    <h1>Hora da Estrela</h1>
                    <p>“A Hora da Estrela” é o último romance da escritora brasileira Clarice Lispector, publicado em 1977. Trata-se de uma obra instigante e original, de cunho autobiográfico, pertencente à Terceira Geração Modernista.
                        É classificada como um romance intimista, também conhecido como romance psicológico, estilo em que a autora se destaca. Afinal, a obra de Clarice é marcada por suas emoções e sentimentos pessoais.</p>
                    <button>Adquira Agora</button>
                </div>

                <div class="livros">
                    <img src="../assets/img/LIVROS/horaEstrela.png" alt="Hora Estrela">
                    <img src="../assets/img/LIVROS/picapauAmarelo.png" alt="Pica-pau Amarelo">
                </div>
            </div>

            <div class="slider-content">
                <img class="AlgoRelacionado" src="../assets/img/LIVROS/picapauAmarelo2.png" alt="O PicaPau Amarelo">

                <div class="conteudo">
                    <h1>Pica-Pau Amarelo</h1>
                    <p>"O Picapau Amarelo" é uma obra-prima da literatura brasileira que encanta
                        gerações. Com sua escrita envolvente e personagens carismáticos, Monteiro
                        Lobato nos leva a um universo mágico e cheio de possibilidades. Essa história
                        cativante desperta a imaginação, ensina importantes lições e proporciona
                        momentos de pura diversão. Não perca a chance de se apaixonar por esse
                        clássico da literatura infantil e embarcar em uma aventura inesquecível
                        no Sítio do Picapau Amarelo!</p>
                    <button>Adquira Agora</button>
                </div>

                <div class="livros">
                    <img src="../assets/img/LIVROS/picapauAmarelo.png" alt="Pica-pau Amarelo">
                    <img src="../assets/img/LIVROS/hobbit.png" alt="O Hobbit">
                </div>
            </div>

            <div class="slider-content">
                <img class="AlgoRelacionado" src="../assets/img/LIVROS/hobbit2.png" alt="O Hobbit">

                <div class="conteudo">
                    <h1>O Hobbit</h1>
                    <p>Bilbo Bolseiro, um hobbit tranquilo, é levado pelo mago Gandalf a viver uma aventura com anões para recuperar um tesouro guardado pelo dragão Smaug. Ao longo da jornada, ele enfrenta perigos e se torna mais corajoso e esperto, voltando para casa transformado.</p>
                    <button>Adquira Agora</button>
                </div>

                <div class="livros">
                    <img src="../assets/img/LIVROS/hobbit.png" alt="O Hobbit">
                    <img src="../assets/img/LIVROS/pedraFilosofal.png" alt="Harry Potter e a Pedra Filosofal">
                </div>
            </div>

            <div class="slider-content">
                <img class="AlgoRelacionado" src="../assets/img/LIVROS/pedraFilosofal2.png" alt="Harry Potter e a Pedra Filosofal">

                <div class="conteudo">
                    <h1>Pedra Filosofal</h1>
                    <p>Harry Potter é um garoto órfão que descobre, ao completar 11 anos, que é um bruxo. Ele vai estudar na escola de magia Hogwarts, onde faz amigos como Ron Weasley e Hermione Granger.
                        Durante o ano, Harry descobre a existência da Pedra Filosofal, um objeto mágico muito poderoso, e suspeita que alguém está tentando roubá-la. Com a ajuda dos amigos, ele enfrenta desafios para protegê-la e acaba confrontando Lord Voldemort.</p>
                    <button>Adquira Agora</button>
                </div>

                <div class="livros">
                    <img src="../assets/img/LIVROS/pedraFilosofal.png" alt="Harry Potter e a Pedra Filosofal">
                    <img src="../assets/img/LIVROS/guerraTronos.png" alt="A guerra dos Tronos">
                </div>
            </div>

            <div class="slider-content">
                <img class="AlgoRelacionado" src="../assets/img/LIVROS/guerraTronos2.png" alt="A guerra dos Tronos">

                <div class="conteudo">
                    <h1>A Guerra dos Tronos</h1>
                    <p>Neste livro, somos apresentados a diversos personagens que vão nos guiar pela trama. Entre eles, destacam-se os membros da família Stark, que governam o norte do reino. Eddard Stark, o patriarca da família, é chamado pelo rei Robert Baratheon para ser sua Mão, ou seja, seu braço direito no governo. Isso coloca Stark em uma posição de poder, mas também de perigo, pois ele começa a descobrir segredos que podem desestabilizar o reino.</p>
                    <button>Adquira Agora</button>
                </div>

                <div class="livros">
                    <img src="../assets/img/LIVROS/guerraTronos.png" alt="A guerra dos Tronos">
                    <img src="../assets/img/LIVROS/livroVidasSecas.png" alt="Vidas Secas">
                </div>
            </div>

        </section>
    </main>

    <!-- Gsap -->
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.14.2/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.14.2/dist/ScrollTrigger.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.14.2/dist/SplitText.min.js"></script>
    <!-- JS -->
    <script src="../assets/js/inicio.js"></script>
    <script src="../assets/js/nav.js"></script>


    <script>
        console.log("JS carregado");
    </script>
</body>