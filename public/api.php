<?php

use App\Api\GetMeals;

require_once "./../src/Api/GetMeals.php";

header("Content-Type: application/json");

if (isset($_GET["id"])) {
    echo GetMeals::getMealWithId((int)$_GET["id"]);
} elseif (isset($_GET["all"]) && $_GET["all"] === "true") {
    echo GetMeals::getAllMealPlans();
} else {
    echo json_encode(["error" => "No meal ID provided!"]);
}