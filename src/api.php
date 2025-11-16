<?php

namespace App;

require_once __DIR__ . '/../vendor/autoload.php';

use Classes\Seeder;

// Generate all meal plans
$mealPlans = Seeder::generate();

// Read the Accept header
$acceptHeader = $_SERVER['HTTP_ACCEPT'] ?? '';
$wantsJson = str_contains($acceptHeader, 'application/json');

// If client explicitly requests JSON, return JSON
if ($wantsJson) {
    header("Content-Type: application/json");
    echo json_encode($mealPlans, JSON_PRETTY_PRINT);
    exit;
}

// Otherwise (typical browser navigation), render HTML page for demo
// You can either include a demo template, or redirect, or render inline