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


$generos_desejados = ['Ficção', 'Romance', 'Suspense', 'Terror'];
$acervo_por_genero = [];

foreach ($generos_desejados as $gen) {
    // JOIN para buscar a imagem principal de cada livro
    $sql_acervo = "SELECT l.*, i.caminho 
                   FROM livros l 
                   LEFT JOIN livros_imagens i ON l.id_livro = i.id_livro AND i.principal = 1
                   WHERE l.categoria = ? 
                   LIMIT 6";

    $stmt_acervo = $conn->prepare($sql_acervo);
    $stmt_acervo->bind_param("s", $gen);
    $stmt_acervo->execute();
    $res = $stmt_acervo->get_result();

    while ($livro = $res->fetch_assoc()) {
        $acervo_por_genero[$gen][] = $livro;
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- BootsTrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <!-- Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
    <!-- CSS -->
    <link rel="stylesheet" href="../assets/css/inicio.css">
    <link rel="stylesheet" href="../assets/css/nav.css">

    <title>Atenas</title>
</head>

<body>

    <div class="dock">
        <div class="icon-nav"><a href="#inicio"><i class="fa-solid fa-house"></i></a></div>
        <div class="icon-nav"><a href="acervocliente.php"><i class="fas fa-book"></i></a></div>
        <div class="icon-nav"><a href="meus_emprestimos.php"><i class="fas fa-exchange-alt"></i></a></div>
    </div>

    <section class="slider">
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
                        <a href="acervocliente.php">Acervo</a>
                        <a href="meus_emprestimos.php">meus emprestimos</a>
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

            <div class="slider-content" id="inicio">
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

    <!-- Livros Destaques -->

    <section class="section2">
        <h2>Destaque da Semana</h2>

        <!-- Este container será o 'gatilho' e o que transborda -->
        <div class="scroll-container">

            <div class="scroll-content">

                <div class="item">
                    <div class="card">
                        <img src="../assets/img/LIVROS/pedraFilosofal.png" alt="Harry Potter">
                        <div class="desc">
                            <h4>Harry Potter e a Pedra Filosofal</h4>
                            <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Impedit deleniti non odit soluta et, neque laboriosam facilis dolores odio eius, cum explicabo pariatur minus ad alias laudantium quidem dicta nostrum.</p>
                        </div>

                        <a href="acervocliente.php">Adiquira Agora</a>
                    </div>
                </div>

                <div class="item">
                    <div class="card">
                        <img src="../assets/img/LIVROS/livroVidasSecas.png" alt="Livro 2">
                        <div class="desc">
                            <h4>Vidas Secas</h4>
                            <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Impedit deleniti non odit soluta et, neque laboriosam facilis dolores odio eius, cum explicabo pariatur minus ad alias laudantium quidem dicta nostrum.</p>
                        </div>

                        <a href="acervocliente.php">Adiquira Agora</a>
                    </div>
                </div>

                <div class="item">
                    <div class="card">
                        <img src="../assets/img/LIVROS/picapauAmarelo.png" alt="Livro 2">
                        <div class="desc">
                            <h4>Pica-Pau Amarelo</h4>
                            <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Impedit deleniti non odit soluta et, neque laboriosam facilis dolores odio eius, cum explicabo pariatur minus ad alias laudantium quidem dicta nostrum.</p>
                        </div>

                        <a href="acervocliente.php">Adiquira Agora</a>
                    </div>
                </div>

                <div class="item">
                    <div class="card">
                        <img src="../assets/img/LIVROS/guerraTronos.png" alt="Livro 2">
                        <div class="desc">
                            <h4>A Guerra dos Tronos</h4>
                            <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Impedit deleniti non odit soluta et, neque laboriosam facilis dolores odio eius, cum explicabo pariatur minus ad alias laudantium quidem dicta nostrum.</p>
                        </div>

                        <a href="acervocliente.php">Adiquira Agora</a>
                    </div>
                </div>

                <div class="item">
                    <div class="card">
                        <img src="../assets/img/LIVROS/hobbit.png" alt="Livro 2">
                        <div class="desc">
                            <h4>O Hobbit</h4>
                            <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Impedit deleniti non odit soluta et, neque laboriosam facilis dolores odio eius, cum explicabo pariatur minus ad alias laudantium quidem dicta nostrum.</p>
                        </div>

                        <a href="acervocliente.php">Adiquira Agora</a>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="section-acervo">
        <div class="container-fluid" style="padding: 0 5%;">

            <?php foreach ($acervo_por_genero as $genero => $livros): ?>
                <div class="genero-container">
                    <div class="header-genero">
                        <h2 class="titulo-genero"><?= $genero ?></h2>
                        <a href="acervocliente.php?genero=<?= urlencode($genero) ?>" class="link-ver-tudo">Ver tudo <i class="bi bi-chevron-right"></i></a>
                    </div>

                    <div class="row-streaming">
                        <?php if (empty($livros)): ?>
                            <p class="text-white-50">Nenhum livro disponível em <?= $genero ?> no momento.</p>
                        <?php else: ?>
                            <?php foreach ($livros as $livro): ?>
                                <div class="card-streaming">
                                    <div class="capa-box">
                                        <div class="tags-livro">
                                            <span class="tag-item">NOVO</span>
                                            <span class="tag-item hd">DIGITAL</span>
                                        </div>

                                        <?php
                                        $caminho_banco = trim($livro['caminho']);

                                        if (empty($caminho_banco)) {
                                            // Caso não tenha nada no banco
                                            $img_final = "../assets/img/LIVROS/default.png";
                                        } elseif (strpos($caminho_banco, 'assets/') !== false) {
                                            // Se o banco JÁ TIVER "assets/...", apenas removemos pontos extras e colocamos ../ na frente
                                            // Isso corrige casos como "../assets/..." ou "assets/..." que estão no seu print
                                            $limpo = str_replace('../', '', $caminho_banco);
                                            $img_final = "../" . $limpo;
                                        } else {
                                            // Se o banco tiver APENAS o nome da imagem (ex: 69ff58d27d35e.png)
                                            $img_final = "../assets/img/LIVROS/" . $caminho_banco;
                                        }
                                        ?>

                                        <img src="<?= $img_final ?>" alt="<?= htmlspecialchars($livro['titulo']) ?>">

                                        <!-- <div class="overlay-info">
                                            <a href="detalhes_livro.php?id=<?= $livro['id_livro'] ?>" class="btn-play">
                                                <i class="bi bi-plus-circle"></i>
                                            </a>
                                        </div> -->
                                    </div>
                                    <div class="card-footer-info">
                                        <h4><?= htmlspecialchars($livro['titulo']) ?></h4>
                                        <div class="meta-data">
                                            <span><?= $livro['ano_publicacao'] ?></span>
                                            <span>Disponível: <?= $livro['quantidade'] ?></span>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>
    </section>

    </main>

    <!-- ====================== RODAPÉ ====================== -->
    <footer id="contato" class="bg-black text-white py-5 border-top border-gold border-opacity-10">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5 class="text-gold">Biblioteca Athenas</h5>
                    <p class="small text-white-50">Preservando o legado clássico para as novas gerações.</p>
                    <img src="../assets/img/LOGOS/logo1.png" alt="Logo" style="max-height: 60px; opacity: 0.9;">
                </div>

                <div class="col-md-4 mb-4">
                    <h5 class="text-gold">Contato</h5>
                    <ul class="list-unstyled small">
                        <li class="mb-2">📧 <a href="mailto:testesenac1104@gmail.com" class="text-white-50">contato@bibliotecaathenas.com</a></li>
                        <li class="mb-2">📱 <a href="https://wa.me/5511999999999" target="_blank" class="text-white-50">(11) 99999-9999</a></li>
                        <li class="mb-2">📍 Rua Saigiro Nakamura 400, São José dos Campos, SP</li>
                    </ul>
                </div>

                <div class="col-md-4 mb-4">
                    <h5 class="text-gold">Links Rápidos</h5>
                    <ul class="list-unstyled small">
                        <li><a href="./pages/atualizaçao.php" class="text-white-50">Catálogo Completo</a></li>
                        <li><a href="./pages/atualizaçao.php" class="text-white-50">Eventos e Debates</a></li>
                        <li><a href="./pages/login.php" class="text-white-50">Área do Leitor</a></li>
                        <li><a href="./pages/atualizaçao.php" class="text-white-50">Política de Privacidade</a></li>
                    </ul>
                </div>
            </div>

            <hr class="border-gold border-opacity-10">
            <div class="text-center small text-white-50">
                © 2026 Biblioteca Athenas - Todos os direitos reservados.
            </div>
        </div>
    </footer>


    <!-- Gsap -->
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.14.2/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.14.2/dist/ScrollTrigger.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.14.2/dist/SplitText.min.js"></script>
    <!-- Lenis -->
    <script src="https://unpkg.com/lenis@1.1.13/dist/lenis.min.js"></script>
    <!-- JS -->
    <script src="../assets/js/inicio.js"></script>
    <script src="../assets/js/nav.js"></script>


    <script>
        console.log("JS carregado");
    </script>
</body>