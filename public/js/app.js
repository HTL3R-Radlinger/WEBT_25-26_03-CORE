// public/js/app.js

async function loadMealPlans() {
    try {
        const response = await fetch('/index.php', {
            headers: {
                "Accept": "application/json"
            }
        });

        if (!response.ok) {
            throw new Error("HTTP error: " + response.status);
        }

        const data = await response.json();
        renderMealPlans(data);
    } catch (error) {
        console.error("Error fetching meal plans:", error);
        const container = document.getElementById('meal-plans');
        container.textContent = `Could not load meal plans. Error: ${error}`;
    }
}

function renderMealPlans(plans) {
    const container = document.getElementById('meal-plans');
    container.innerHTML = "";

    plans.forEach(plan => {
        const div = document.createElement('div');

        const mealsHtml = plan.meals.map(meal => {
            // Turn string into array
            let allergensArr = [];
            if (typeof meal.allergens === 'string') {
                allergensArr = meal.allergens
                    .split(',')                     // split at commas :contentReference[oaicite:0]{index=0}
                    .map(a => a.trim());             // trim whitespace
            } else if (Array.isArray(meal.allergens)) {
                allergensArr = meal.allergens;
            }

            const allergens = allergensArr.map(a => escapeHtml(a)).join(', ');

            return `
        <li>
          <strong>${escapeHtml(meal.name)}</strong> — €${meal.price}
          <br><small>Allergens: ${allergens || '—'}</small>
        </li>
      `;
        }).join('');

        div.innerHTML = `
      <h2>${escapeHtml(plan.name)}</h2>
      <p><strong>School:</strong> ${escapeHtml(plan.schoolName)}</p>
      <p><strong>Week:</strong> ${escapeHtml(plan.weekOfDelivery)}</p>
      <ul>${mealsHtml}</ul>
      <hr>
    `;

        container.appendChild(div);
    });
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


// Start loading when page is ready
document.addEventListener('DOMContentLoaded', loadMealPlans);