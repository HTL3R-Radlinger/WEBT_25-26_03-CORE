<?php

namespace App;

require __DIR__ . '/../vendor/autoload.php';

use App\Seeder\MealSeeder;

class GetMeals
{
    public static function getMealWithId(int $id): false|string
    {
        $mealPlans = MealSeeder::generate();
        foreach ($mealPlans as $mealPlan) {
            if (!isset($mealPlan->meals) || !is_array($mealPlan->meals)) {
                continue;
            }
            foreach ($mealPlan->meals as $meal) {
                if (isset($meal->id) && $meal->id === $id) {
                    return json_encode([
                        "id" => $meal->id,
                        "name" => $meal->name,
                        "allergens" => $meal->allergens,
                        "nutritionalInfo" => $meal->nutritionalInfo,
                        "price" => $meal->price
                    ]);
                }
            }
        }
        return json_encode(["error" => "No meal with ID found!"]);
    }

    public static function getAllMealPlans(): string
    {
        $mealPlans = MealSeeder::generate();
        return json_encode($mealPlans);
    }
}