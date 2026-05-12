gsap.registerPlugin(SplitText);

const livroMenor = document.querySelectorAll(".livros img:nth-child(2)");
const slides = document.querySelectorAll(".slider-content");

let timer = 0;
let click = true;

function titulo() {

    const split = SplitText.create(".slider-content.ativo h1", {
        type: "chars",
        mask: "chars"
    });

    gsap.from(split.chars, {
        opacity: 0,
        duration: .4,
        y: "100%",
        stagger: .05,
        delay: .5
    });
}

livroMenor.forEach((livroMenor) => {

    livroMenor.onclick = () => {

        if (click) {
            click = false

            const slideAtivo = document.querySelector(".slider-content.ativo");

            slideAtivo.classList.remove("ativo");

            if (timer == 5) {
                timer = 0;
            } else {
                timer++;
            }


            console.log(timer);

            slides[timer].classList.add("ativo");

            titulo();

            // delay do click
            setTimeout(() => {
                click = true
            }, 1000)
        }

    }
});



// Scroll horizontal

// Registro do plugin
gsap.registerPlugin(ScrollTrigger);

const content = document.querySelector(".scroll-content");

gsap.to(content, {
    // Move o conteúdo para a esquerda baseado na sua largura total
    x: () => -(content.scrollWidth - window.innerWidth),
    ease: "none",
    scrollTrigger: {
        trigger: ".section2", // Onde a animação começa
        start: "top top",     // Quando o topo da seção encosta no topo da tela
        end: () => "+=" + content.scrollWidth, // Duração do scroll baseada no tamanho do conteúdo
        scrub: 1,             // Suavidade (conforme você gira o mouse)
        pin: true,            // Trava a tela enquanto o scroll horizontal acontece
        invalidateOnRefresh: true, // Recalcula se a janela mudar de tamanho
    }
});


// Scroll vertical com efeito de "Unstacking" (Revelação)

// Inicializa o Lenis
const lenis = new Lenis({
  duration: 1.2,      // Duração do deslize (mais alto = mais suave)
  easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)), // Função de suavização
  smoothWheel: true,  // Suaviza o scroll do mouse
});

// Integra o Lenis com o ScrollTrigger do GSAP
lenis.on('scroll', ScrollTrigger.update);

gsap.ticker.add((time) => {
  lenis.raf(time * 1000);
});

gsap.ticker.lagSmoothing(0);

// Criando o efeito de "Unstacking" (Revelação)
ScrollTrigger.create({
    trigger: ".slider", // A seção que vai ficar presa
    start: "top top",   // Começa quando o topo dela toca o topo da tela
    end: "+=100%",      // O efeito dura 100% da altura da viewport (pode aumentar se quiser que demore mais)
    pin: true,          // Prende a seção .slider
    pinSpacing: false,  // IMPORTANTE: Remove o espaço, permitindo que a próxima seção suba por cima
});




// Mapa CN

