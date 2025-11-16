<?php
require __DIR__ . '/../vendor/autoload.php';

use Classes\Seeder;

$results = Seeder::generate();
echo "<pre>";
print_r($results);
echo "</pre>";
