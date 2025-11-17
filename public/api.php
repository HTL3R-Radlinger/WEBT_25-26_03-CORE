<?php

use App\GetMeals;

require_once "./../src/GetMeals.php";

header("Content-Type: application/json");

if (isset($_GET["id"])) {
    echo GetMeals::getMealWithId((int)$_GET["id"]);
} elseif (isset($_GET["all"]) && $_GET["all"] === "true") {
    echo GetMeals::getAllMealPlans();
} else {
    echo json_encode(["error" => "No meal ID provided!"]);
}