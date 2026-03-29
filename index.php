<?php

require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

// Load env
$dotenv = Dotenv::createImmutable(__DIR__ . '/send-mail/');
$dotenv->load();

// Headers (API)
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Only POST allowed
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "Method Not Allowed"]);
    exit;
}

// Get JSON body
$data = json_decode(file_get_contents("php://input"), true);

// Validate
if (
    empty($data['to']) ||
    empty($data['subject']) ||
    empty($data['message'])
) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Missing fields"]);
    exit;
}

// Send email
$response = MailService::send(
    $data['to'],
    $data['subject'],
    $data['message']
);

// Response
http_response_code($response['success'] ? 200 : 500);
echo json_encode($response);