<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Seeder\MealSeeder;

$results = MealSeeder::generate();
header("Content-Type: application/json");
echo json_encode($results);