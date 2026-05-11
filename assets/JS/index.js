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


        gsap.registerPlugin(ScrollTrigger);

gsap.registerPlugin(ScrollTrigger);



/* TIMELINE */

const tl = gsap.timeline();

/* LOGO */

tl.from(".intro-logo", {
    opacity: 0,
    y: 50,
    duration: 1.5,
    ease: "power3.out"
})

/* ESPERA */

.to({}, {
    duration: 1
})

/* PORTAS ABRINDO */

.to(".left-door", {
    rotateY: -100,
    x: "-40%",
    duration: 3,
    ease: "power4.inOut"
}, "open")

.to(".right-door", {
    rotateY: 100,
    x: "40%",
    duration: 3,
    ease: "power4.inOut"
}, "open")

/* CÂMERA AVANÇANDO */

.to(".partenon", {
    scale: 1,
    duration: 4,
    ease: "power3.inOut"
}, "open")

/* NÉVOA */

.to(".fog", {
    opacity: 0,
    duration: 4
}, "open")

/* LOGO SOME */

.to(".intro-logo", {
    opacity: 0,
    duration: 1.5
}, "-=2")

/* REVELA SITE */

.to("header, main, .quem-somos", {
    opacity: 1,
    duration: 2,
    stagger: 0.2
}, "-=1.5")

/* REMOVE INTRO */

.to(".intro", {
    opacity: 0,
    duration: 1.5,
    onComplete: () => {
        document.querySelector(".intro").remove();
    }
});

const canvas = document.getElementById('particles');
    const ctx = canvas.getContext('2d');
    let particles = [];

    function resizeCanvas() {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
    }

    class Particle {
        constructor() {
            this.reset();
        }

        reset() {
            this.x = Math.random() * canvas.width;
            this.y = canvas.height * (Math.random() * 0.8 + 0.2);
            this.size = Math.random() * 3.5 + 1.2;
            this.speedX = Math.random() * 1.2 - 0.6;
            this.speedY = -Math.random() * 2.2 - 0.6; // sobe
            this.opacity = Math.random() * 0.7 + 0.3;
            this.life = Math.random() * 180 + 120;
            this.hue = Math.random() * 12 + 38; // tons de dourado/âmbar
            this.glow = Math.random() > 0.7 ? 15 : 8;
        }

        update() {
            this.x += this.speedX;
            this.y += this.speedY;
            this.speedY -= 0.012; // acelera para cima (leveza)
            this.speedX *= 0.985;
            this.opacity -= 0.0035;
            this.life--;
            if (this.life <= 0 || this.opacity <= 0) this.reset();
        }

        draw() {
            ctx.save();
            ctx.globalAlpha = this.opacity;
            ctx.shadowBlur = this.glow;
            ctx.shadowColor = `hsl(${this.hue}, 90%, 75%)`;

            ctx.fillStyle = `hsl(${this.hue}, 95%, 85%)`;
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
            ctx.fill();

            // Brilho extra no centro
            if (this.size > 2.5) {
                ctx.shadowBlur = 25;
                ctx.fillStyle = 'rgba(255, 240, 180, 0.6)';
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.size * 0.4, 0, Math.PI * 2);
                ctx.fill();
            }
            ctx.restore();
        }
    }

    function createParticles(count) {
        particles = [];
        for (let i = 0; i < count; i++) {
            particles.push(new Particle());
        }
    }

    function animateParticles() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        // Desenhar partículas de trás para frente (melhor profundidade)
        for (let i = 0; i < particles.length; i++) {
            particles[i].update();
            particles[i].draw();
        }

        requestAnimationFrame(animateParticles);
    }

    // ====================== ANIMAÇÃO PRINCIPAL ======================
    window.onload = function() {
        resizeCanvas();
        createParticles(420); // Partículas douradas avançadas
        animateParticles();

        setTimeout(() => {
            document.getElementById('gateLeft').classList.add('open');
            document.getElementById('gateRight').classList.add('open');

            setTimeout(() => {
                document.getElementById('title').classList.add('show');
                document.getElementById('enterBtn').classList.add('show');
            }, 2100);
        }, 700);
    };

    window.addEventListener('resize', resizeCanvas);

    function enterSite() {
        const intro = document.getElementById('intro');
        intro.classList.add('show-temple');

        setTimeout(() => {
            intro.style.opacity = '0';
        }, 900);

        setTimeout(() => {
            intro.style.display = 'none';
            document.getElementById('main-content').style.display = 'block';
        }, 3000);
    }

    // CSS dinâmico para o fundo
    const style = document.createElement('style');
    style.innerHTML = `
            #intro.show-temple::before {
                opacity: 1 !important;
            }
        `;
    document.head.appendChild(style);