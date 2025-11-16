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

        if (!response.ok) throw new Error(`HTTP error: ${response.status}`);

        const data = await response.json();
        renderMealPlans(data);
    } catch (error) {
        console.error('Error fetching meal plans:', error);
        container.textContent = `Could not load meal plans. Error: ${error.message}`;
    }
}

// Render all meal plans to the page
function renderMealPlans(plans) {
    const container = document.getElementById('meal-plans');
    container.innerHTML = "";  // Clear existing content

    plans.forEach(plan => {
        const mealsHtml = plan.meals.map(meal => {
            const allergens = formatAllergens(meal.allergens);

            return `
                <li>
                    <strong>${escapeHtml(meal.name)}</strong> — €${meal.price}
                    <br><small>Allergens: ${allergens || '—'}</small>
                </li>
            `;
        }).join('');

        container.innerHTML += `
            <div>
                <h2>${escapeHtml(plan.name)}</h2>
                <p><strong>School:</strong> ${escapeHtml(plan.schoolName)}</p>
                <p><strong>Week:</strong> ${escapeHtml(plan.weekOfDelivery)}</p>
                <ul>${mealsHtml}</ul>
                <hr>
            </div>
        `;
    });
}

// Format allergens, handling both string and array
function formatAllergens(allergens) {
    if (Array.isArray(allergens)) {
        return allergens.map(a => escapeHtml(a)).join(', ');
    } else if (typeof allergens === 'string') {
        return allergens.split(',').map(a => escapeHtml(a.trim())).join(', ');
    }
    return null;
}

// Simple HTML-escaping to avoid XSS
function escapeHtml(text) {
    return (text ?? '')
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

// Load meal plans when the page is ready
document.addEventListener('DOMContentLoaded', loadMealPlans);