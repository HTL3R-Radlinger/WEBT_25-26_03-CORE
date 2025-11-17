<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<div id="mealPlansContainer"></div>
<script>
    async function fetchMealPlans() {
        try {
            const response = await fetch('/api.php?all=true');
            const mealPlans = await response.json();

            const container = document.getElementById('mealPlansContainer');
            container.innerHTML = '';


            mealPlans.forEach(plan => {
                const planDiv = document.createElement('div');
                planDiv.className = 'meal-plan';
                planDiv.innerHTML = `<h2>${plan.name} - ${plan.schoolName} (${plan.weekOfDelivery})</h2>`;

                plan.meals.forEach(meal => {
                    const mealDiv = document.createElement('div');
                    mealDiv.className = 'meal';
                    mealDiv.innerHTML = `
                    <strong>${meal.name}</strong> - €${meal.price}<br>
                    Allergens: ${meal.allergens}<br>
                    Nutritional Info: ${meal.nutritionalInfo}
                `;
                    planDiv.appendChild(mealDiv);
                });

                container.appendChild(planDiv);
            });

        } catch (error) {
            console.error("Error fetching meal plans:", error);
        }
    }

    fetchMealPlans();
</script>
</body>
</html>