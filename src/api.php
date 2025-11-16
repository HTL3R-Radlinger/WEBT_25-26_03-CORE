<?php

namespace App;
require_once __DIR__ . '/../vendor/autoload.php';

use Classes\Seeder;

// Generate all meal plans
$mealPlans = Seeder::generate();

// --- Validate request header ---
$acceptHeader = $_SERVER['HTTP_ACCEPT'] ?? '';

$wantsJson = str_contains($acceptHeader, 'application/json');

// If client does NOT request JSON → reject
if (!$wantsJson) {
    http_response_code(406); // Not Acceptable
    echo "Client must request JSON via: Accept: application/json";
    exit;
}

// --- GET parameter: mealplan=ID ---
$id = isset($_GET['mealplan']) ? intval($_GET['mealplan']) : null;

// No ID given → error
if ($id === null) {
    http_response_code(400); // Bad Request
    echo json_encode(["error" => "Missing GET parameter 'mealplan'"]);
    exit;
}

// Check if ID exists
$found = null;
foreach ($mealPlans as $plan) {
    if ($plan->id === $id) {
        $found = $plan;
        break;
    }
}

if (!$found) {
    http_response_code(404);
    echo json_encode(["error" => "Meal plan not found"]);
    exit;
}

// --- Output JSON ---
header("Content-Type: application/json");
echo json_encode($found, JSON_PRETTY_PRINT);
