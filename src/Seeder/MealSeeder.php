<?php

namespace App\Seeder;
use App\Classes\Meal;
use App\Classes\MealPlan;

class MealSeeder
{
    public static function generate(): array
    {
        $plans = [];
        $anz_plans = 3;
        for ($plans_index = 0; $plans_index < $anz_plans; $plans_index++) {
            $meals = [];
            $anz_meals = 4;
            for ($meal_index = 0; $meal_index < $anz_meals; $meal_index++) {
                $meals[] = new Meal(
                    $meal_index,
                    "Meal $meal_index",
                    "Gluten, Lactose",
                    "Calories: " . rand(400, 700),
                    rand(5, 10)
                );
            }
            $plans[] = new MealPlan(
                $plans_index,
                "Meal Plan $plans_index",
                "HTL Rennweg",
                "Week $plans_index",
                $meals
            );
        }
        return $plans;
    }
}
