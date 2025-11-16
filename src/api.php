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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Meal Plans Demo</title>
</head>
<body>
<h1>Meal Plans (HTML view)</h1>
<div id="meal-plans">Loading …</div>

<script>
    // Inline some data as fallback
    const mealPlans = <?php echo json_encode($mealPlans, JSON_PRETTY_PRINT); ?>;

    function renderMealPlans(plans) {
        const container = document.getElementById('meal-plans');
        container.innerHTML = "";
        plans.forEach(plan => {
            const div = document.createElement('div');
            div.innerHTML = `<h2>${plan.name}</h2>
                         <p>School: ${plan.schoolName}, Week: ${plan.week}</p>
                         <ul>
                           ${plan.meals.map(m => `<li>${m.name} — €${m.price} (Allergens: ${m.allergens.join(', ')})</li>`).join('')}
                         </ul><hr>`;
            container.appendChild(div);
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        renderMealPlans(mealPlans);
        // Also, optionally, you could re-fetch via fetch() here if you want fresh data
    });
</script>
</body>
</html>
