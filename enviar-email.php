<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método não permitido.']);
    exit;
}

$nome = filter_input(INPUT_POST, 'nome', FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$assunto = filter_input(INPUT_POST, 'assunto', FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
$mensagem = filter_input(INPUT_POST, 'mensagem', FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);

if (!$nome || !$email || !$assunto || !$mensagem) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Por favor, preencha todos os campos corretamente.']);
    exit;
}

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'oliverd39@gmail.com';
    $mail->Password = 'jziz anom hsmp xpko'; // 
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('oliverd39@gmail.com', 'Contato do Site');
    $mail->addAddress('oliverd39@gmail.com'); 

    $mail->isHTML(false);
    $mail->Subject = "Contato via site: $assunto - de $nome";
    $mail->Body = "Nome: $nome\nEmail: $email\nMensagem:\n$mensagem";

    $mail->send();

    echo json_encode(['success' => true, 'message' => 'Mensagem enviada com sucesso!']);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => "Erro ao enviar mensagem: {$mail->ErrorInfo}"]);
}
