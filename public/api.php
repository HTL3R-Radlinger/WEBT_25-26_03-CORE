<?php

use App\GetMeals;

require_once "./../src/GetMeals.php";

header("Content-Type: application/json");

if (isset($_GET["id"])) {
    echo GetMeals::getMealWithId((int)$_GET["id"]);
} else {
    echo json_encode(["error" => "No meal ID provided!"]);
}