/**
 * Lädt alle verfügbaren Speisepläne vom Backend
 * und zeigt sie im HTML-Element #mealPlansContainer an.
 */
async function fetchMealPlans() {
    try {
        // API-Aufruf mit Authentifizierung
        const response = await authFetch('/api.php?all=true');

        // Falls der Benutzer nicht eingeloggt ist
        if (response.status === 401) {
            document.getElementById('mealPlansContainer').innerHTML =
                "<h3>Bitte zuerst einloggen!</h3>";
            return;
        }

        // Antwort in JSON umwandeln
        const mealPlans = await response.json();

        // Container für die Speisepläne leeren
        const container = document.getElementById('mealPlansContainer');
        container.innerHTML = '';

        // Jeden Speiseplan durchgehen
        mealPlans.forEach(plan => {
            // Container für einen einzelnen Speiseplan
            const planDiv = document.createElement('div');
            planDiv.className = 'meal-plan';

            // Überschrift mit Planname, Schule und Lieferwoche
            planDiv.innerHTML = `<h2>${plan.name} - ${plan.schoolName} (${plan.weekOfDelivery})</h2>`;

            // Alle Mahlzeiten des Speiseplans anzeigen
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

            // Speiseplan zum Hauptcontainer hinzufügen
            container.appendChild(planDiv);
        });

    } catch (error) {
        // Fehlerbehandlung bei Netzwerk- oder Serverfehlern
        console.error("Error fetching meal plans:", error);
    }
}

/**
 * Lädt eine einzelne Mahlzeit anhand ihrer ID
 * und zeigt die Details im HTML-Element #mealContainer an.
 */
async function fetchMeal(id) {
    try {
        // API-Aufruf für eine bestimmte Mahlzeit
        const response = await authFetch('/api.php?id=' + id);

        // Falls der Benutzer nicht eingeloggt ist
        if (response.status === 401) {
            document.getElementById('mealPlansContainer').innerHTML =
                "<h3>Bitte zuerst einloggen!</h3>";
            return;
        }

        // Antwort in JSON umwandeln
        const meal = await response.json();
        const container = document.getElementById('mealContainer');

        // Falls die API einen Fehler zurückgibt
        if (meal.error) {
            container.innerHTML = `<h1>${meal.error}</h1>`;
            return;
        }

        // Anzeige der Mahlzeitendetails
        container.innerHTML = `
            <h1>${meal.name}</h1>
            <p><span class="label">Allergens:</span> ${meal.allergens}</p>
            <p><span class="label">Description:</span> ${meal.nutritionalInfo}</p>
            <p><span class="label">Price:</span> €${meal.price.toFixed(2)}</p>
        `;
    } catch (error) {
        // Allgemeine Fehlerbehandlung
        console.error(error);
        document.getElementById('mealContainer').innerHTML = `<h1>Error loading meal</h1>`;
    }
}

/**
 * Liest die URL-Parameter aus, um zu entscheiden,
 * ob alle Speisepläne oder nur eine Mahlzeit geladen werden sollen.
 */
const urlParams = new URLSearchParams(window.location.search);
const mealId = urlParams.get('id') || "all";

// Entscheidung: alle Pläne oder eine Mahlzeit laden
if (mealId === "all")
    fetchMealPlans().then(_ => console.log("Fetched all Plans."));
else
    fetchMeal(mealId).then(_ => console.log("Fetched Meal with id: " + mealId));

/**
 * Speichert das JWT-Access-Token im LocalStorage
 */
function saveToken(token) {
    localStorage.setItem("access_token", token);
}

/**
 * Holt das gespeicherte JWT-Access-Token aus dem LocalStorage
 */
function getToken() {
    return localStorage.getItem("access_token");
}

/**
 * Wrapper für fetch(), der automatisch das
 * Authorization-Header-Feld mit JWT setzt.
 */
async function authFetch(url, options = {}) {
    const token = getToken();
    options.headers = options.headers || {};

    if (token) {
        options.headers["Authorization"] = "Bearer " + token;
    }

    return fetch(url, options);
}

/**
 * Login-Button:
 * - Ruft /login.php auf
 * - Speichert das Access-Token
 * - Lädt danach die entsprechenden Daten neu
 */
document.getElementById("loginBtn").addEventListener("click", async () => {
    try {
        const res = await fetch("/login.php");
        const data = await res.json();

        if (data.access_token) {
            saveToken(data.access_token);
            alert("Login erfolgreich!");

            // Nach Login Inhalte neu laden
            const urlParams = new URLSearchParams(window.location.search);
            const mealId = urlParams.get('id') || "all";

            if (mealId === "all")
                fetchMealPlans().then(_ => console.log("Fetched all Plans."));
            else
                fetchMeal(mealId).then(_ => console.log("Fetched Meal with id: " + mealId));
        } else {
            alert("Login fehlgeschlagen");
        }
    } catch (e) {
        console.error(e);
        alert("Login Fehler");
    }
});