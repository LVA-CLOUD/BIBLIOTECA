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
