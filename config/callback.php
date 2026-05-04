<?php
session_start();
require '../composer/vendor/autoload.php';
include("conexao.php");

header('Content-Type: application/json');

$input = json_decode(file_get_contents("php://input"));

if (!isset($input->token)) {
    echo json_encode(["status" => "error", "message" => "Token ausente"]);
    exit;
}

// CORREÇÃO: O ID deve ser idêntico ao do HTML (removido o 'q' incorreto)
$clientId = '797914724661-biug0qbtbf9190e5c0m2m714eaoorrvn.apps.googleusercontent.com';
$client = new Google_Client(['client_id' => $clientId]);

$payload = $client->verifyIdToken($input->token);

if ($payload) {
    $emailGoogle = $payload['email'];
    $nomeGoogle = $payload['name'];

    $sql = "SELECT id_regi, id_nivel FROM registro WHERE email_regi = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $emailGoogle);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $userDB = $result->fetch_assoc();
        $_SESSION['id_usuario'] = $userDB['id_regi'];
        $_SESSION['id_nivel'] = $userDB['id_nivel'];
        
        // Retornamos o nível para o JavaScript saber para onde redirecionar
        echo json_encode([
            "status" => "success", 
            "nivel" => $userDB['id_nivel']
        ]);
    } else {
        $_SESSION['google_data'] = [
            "nome" => $nomeGoogle,
            "email" => $emailGoogle
        ];
        echo json_encode(["status" => "new_user"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Token inválido"]);
}
exit;