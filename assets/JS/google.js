function handleCredentialResponse(response) {
    // Certifique-se que o caminho abaixo aponta corretamente para o callback.php
    fetch("../config/callback.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ token: response.credential })
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === "success") {
            // Lógica de redirecionamento baseada no nível vindo do PHP
            if (data.nivel == 2) {
                window.location.href = "acervofuncionario.php";
            } else {
                window.location.href = "inicio.php";
            }
        } else if (data.status === "new_user") {
            // Se não tem conta, vai para a página de registro
            window.location.href = "registrar.php"; 
        } else {
            alert("Erro na autenticação: " + (data.message || "Tente novamente."));
        }
    })
    .catch(err => {
        console.error("Erro no fetch:", err);
        alert("Erro ao conectar com o servidor.");
    });
}