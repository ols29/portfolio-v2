<?php
// enviar-email.php

// Permite que o arquivo responda a requisições CORS (se precisar)
// header('Access-Control-Allow-Origin: *');

// Verifica se o método é POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Método não permitido
    echo "Método não permitido.";
    exit;
}

// Obtém os dados do formulário
$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$mensagem = filter_input(INPUT_POST, 'mensagem', FILTER_SANITIZE_STRING);

// Validações básicas
if (!$nome || !$email || !$mensagem) {
    http_response_code(400); // Requisição inválida
    echo "Por favor, preencha todos os campos corretamente.";
    exit;
}

// Monta o corpo do email
$to = 'oliver@analyst-oliver.tech'; // Coloque seu email aqui
$subject = "Contato via site de $nome";
$body = "Nome: $nome\nEmail: $email\nMensagem:\n$mensagem";
$headers = "From: $email\r\nReply-To: $email\r\n";

// Tenta enviar o email
if (mail($to, $subject, $body, $headers)) {
    echo "Mensagem enviada com sucesso!";
} else {
    http_response_code(500); // Erro no servidor
    echo "Erro ao enviar a mensagem. Tente novamente mais tarde.";
}
