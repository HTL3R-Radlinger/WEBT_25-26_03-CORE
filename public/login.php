<?php
// login.php
require_once __DIR__ . "/../src/Api/Security/JwtService.php";

use App\Api\Security\JwtService;

header("Content-Type: application/json");

$secret = 'password123';
$jwtService = new JwtService($secret);

$now = time();

$payload = [
    'sub' => 1,
    'role' => 'system',
    'iat' => $now,
    'exp' => $now + 3600 // 1 Stunde gültig
];

$token = $jwtService->encode($payload);

echo json_encode([
    'access_token' => $token,
    'token_type' => 'Bearer',
    'expires_in' => 3600
]);
