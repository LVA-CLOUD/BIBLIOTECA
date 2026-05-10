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

/* SOM */

window.addEventListener("load", () => {

    const sound = document.getElementById("doorSound");

    sound.volume = 0.6;

    setTimeout(() => {
        sound.play();
    }, 1200);

});

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