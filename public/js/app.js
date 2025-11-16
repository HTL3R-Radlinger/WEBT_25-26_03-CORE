// Fetch and load meal plans
async function loadMealPlans() {
    const container = document.getElementById('meal-plans');
    container.textContent = 'Loading…';

    try {
        const response = await fetch('/index.php', {
            headers: {
                "Accept": "application/json"
            }
        });

        if (!response.ok) throw new Error('HTTP error:' + response.status);

        const data = await response.json();
        renderMealPlans(data);
    } catch (error) {
        console.error('Error fetching meal plans:', error);
        container.textContent = 'Could not load meal plans. Error:' + error.message;
    }
}

// Render all meal plans to the page
function renderMealPlans(plans) {
    const container = document.getElementById('meal-plans');
    container.innerHTML = "";  // Clear existing content

    plans.forEach(plan => {
        const mealsHtml = plan.meals.map(meal => {
            return `
                <li>
                    <strong>${meal.name}</strong> - ${meal.price}€
                    <br><small>Allergens: ${plan.allergens}</small>
                </li>
            `;
        }).join('');

        container.innerHTML += `
            <div>
                <h2>${plan.name}</h2>
                <p><strong>School:</strong> ${plan.schoolName}</p>
                <p><strong>Week:</strong> ${plan.weekOfDelivery}</p>
                <ul>${mealsHtml}</ul>
                <hr>
            </div>
        `;
    });
}

// Load meal plans when the page is ready
document.addEventListener('DOMContentLoaded', loadMealPlans);