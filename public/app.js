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

async function fetchMeal(id) {
    try {
        const response = await fetch(`api.php?id=${id}`);
        const meal = await response.json();

        const container = document.getElementById('mealContainer');

        if (meal.error) {
            container.innerHTML = `<h1>${meal.error}</h1>`;
            return;
        }

        container.innerHTML = `
            <h1>${meal.name}</h1>
            <p><span class="label">Allergens:</span> ${meal.allergens}</p>
            <p><span class="label">Description:</span> ${meal.nutritionalInfo}</p>
            <p><span class="label">Price:</span> €${meal.price.toFixed(2)}</p>
        `;
    } catch (error) {
        console.error(error);
        document.getElementById('mealContainer').innerHTML = `<h1>Error loading meal</h1>`;
    }
}

const urlParams = new URLSearchParams(window.location.search);
const mealId = urlParams.get('id') || "all";
if (mealId === "all") fetchMealPlans();
else fetchMeal(mealId);

function login() {

}