<?php

require_once '../vendor/autoload.php';

use App\Api\Security\JwtService;
use App\Api\Security\JwtAuth;

use App\Api\GetMeals;

$secret = 'password123';

$auth = new JwtAuth(new JwtService($secret));

header("Content-Type: application/json");

if (!$auth->check()) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

if (isset($_GET["id"])) {
    echo GetMeals::getMealWithId((int)$_GET["id"]);
} elseif (isset($_GET["all"]) && $_GET["all"] === "true") {
    echo GetMeals::getAllMealPlans();
} else {
    echo json_encode(["error" => "No meal ID provided!"]);
}