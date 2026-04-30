function handleCredentialResponse(response) {
    fetch("../config/callback.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ token: response.credential })
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === "success") {
            // Se já tem conta, vai para o dashboard que leva ao inicio
            window.location.href = "../config/dashboard.php";
        } else if (data.status === "new_user") {
            // Se não tem conta, vai para o registro
            window.location.href = "registro.php";
        } else {
            alert("Erro na autenticação com o Google.");
        }
    })
    .catch(err => console.error("Erro no fetch:", err));
}