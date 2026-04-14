gsap.registerPlugin(Draggable);

const root = document.documentElement;
const body = document.body;
const loginForm = document.querySelector('.login-form');
const cordBead = document.querySelector('.cord-bead');
const cordLine = document.querySelector('.cord-line');
const hitArea = document.querySelector('.cord-hit');

const bgTitle = document.getElementById('bgTitle');
let typed = false;

// 🔹 começa invisível
gsap.set(bgTitle, { opacity: 0 });

let isOn = false;
const clickSound = new Audio("https://assets.codepen.io/605876/click.mp3");

Draggable.create(hitArea, {
    type: "y",
    bounds: { minY: 0, maxY: 60 },
    onDrag: function () {
        gsap.set(cordBead, { y: this.y });
        gsap.set(cordLine, { attr: { y2: 180 + this.y } });
    },
    onRelease: function () {
        if (this.y > 30) {
            toggleLamp();
        }

        gsap.to([cordBead, hitArea], { y: 0, duration: 0.5, ease: "back.out(2.5)" });
        gsap.to(cordLine, { attr: { y2: 180 }, duration: 0.5, ease: "back.out(2.5)" });
    }
});

function toggleLamp() {
    isOn = !isOn;
    clickSound.play();

    body.setAttribute('data-on', isOn);
    root.style.setProperty('--on', isOn ? 1 : 0);

    if (isOn) {
        loginForm.classList.add('active');
        gsap.to(body, { backgroundColor: "#1c1f24", duration: 0.6 });

        // 🔹 mostra o título com fade
        gsap.to(bgTitle, { opacity: 1, duration: 0.6, ease: "power2.out" });

        // 🔹 efeito máquina de escrever
        if (!typed) {
            typeWriter("BIBLIOTECA ATENAS", bgTitle, 80);
            typed = true;
        }

    } else {
        loginForm.classList.remove('active');
        gsap.to(body, { backgroundColor: "#121417", duration: 0.6 });

        // 🔹 esconde com fade e limpa texto
        gsap.to(bgTitle, {
            opacity: 0,
            duration: 0.4,
            onComplete: () => {
                bgTitle.textContent = "";
                typed = false;
            }
        });
    }
}

// 🔹 função máquina de escrever
function typeWriter(text, element, speed) {
    let i = 0;
    element.textContent = "";

    function typing() {
        if (i < text.length) {
            element.textContent += text.charAt(i);
            i++;
            setTimeout(typing, speed);
        }
    }

    typing();
}


// Botao Login

gsap.registerPlugin(Draggable);

// ... (Mantenha seu código da lâmpada e GSAP que já funciona aqui) ...

function Login() {
    let email = document.getElementById("email").value;
    let senha = document.getElementById("senha").value;

    if (!email || !senha) {
        alert("Preencha todos os campos!");
        return;
    }

    fetch("login.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "email=" + encodeURIComponent(email) + "&senha=" + encodeURIComponent(senha)
    })
        .then(response => response.text())
        .then(data => {
            const resposta = data.trim();

            if (resposta === "Login funcionario") {
                // Redireciona para a pasta principal/cadastro
                window.location.href = "../emprestar.php";
            } else if (resposta === "Login Comum") {
                // Redireciona para a pasta de início
                window.location.href = "inicio.php";
            } else {
                // Exibe o erro vindo do PHP (Senha incorreta, etc)
                alert(resposta);
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert("Erro na conexão com o servidor.");
        });
}
