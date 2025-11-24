<?php
require_once '../vendor/autoload.php';

use App\Api\Security\JwtService;

header('Content-Type: application/json');

$sharedSecret = 'password123';
$jwt = new JwtService($sharedSecret);

$input = json_decode(file_get_contents('php://input'), true) ?: $_POST;
$username = $input['username'] ?? null;

if (!$username) {
    http_response_code(400);
    echo json_encode(['error' => 'username required']);
    exit;
}

$now = time();
$exp = $now + 15 * 60; // 15 Minuten gültig

$payload = [
    'iss' => 'mein-server',
    'sub' => $username,
    'iat' => $now,
    'exp' => $exp,
    'roles' => ['user']
];

$token = $jwt->encode($payload);

echo json_encode([
    'token' => $token,
    'expires' => $exp
]);
