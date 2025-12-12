# Setup

- At first clone the Project ```git clone https://github.com/HTL3R-Radlinger/WEBT_25-26_03-CORE.git```
- Then start the docker container:
  ```cd WEBT_25-26_03-CORE``` and ```docker compose up --build -d```
- Then go into the container bash: ```docker exec -it CORE3 bash```. And run ```composer install``` (This creates the
  vendor
  folder)

## User Story 1

> As a Developer I want to create a class structure, so that it is possible to create own entities for meal
> plans, as well as the representative meals.

### Acceptance Criteria

- A meal plan has a unique ID, name, school name, week of delivery, and a list of meals
- A meal features a unique ID, name, allergens, nutritional information, and price

### Implementation

> The class structure is implemented in ```/src/Classes```.
>
> #### Meal.php
>
> - Public variables are implemented.
> - A ```JsonSerializable``` methode is implemented, to display the data as JSON.
>
> #### MealPlan.php
>
> - Public variables are implemented (including an array for meals).
> - A ```JsonSerializable``` methode is implemented, to display the data as JSON.

## User Story 2

> As a Developer I want to create a seeder class, so that I can quickly create mock data for a presentation.

### Acceptance Criteria

- A seeder class which can create data for demonstrational purposes exists
- The class returns at least 3 meal plans with at least 4 meals per plan
- A demo file that uses and outputs the data returned by the seeder exists

### Implementation

> The seeder is implemented in ```/src/Seeder/MealSeeder.php```.<br>
> A demo file is implemented in ```/public/demo.php```.
>
> With http://localhost:8080/demo.php you can see the demo.
>
> #### MealSeeder.php
> - The seeder generates 3 meal plans, each containing 4 meals.
> #### demo.php
> - The demo uses the seeder to generate the data and displays it as JSON.

## User Story 3

> As a Developer I want to output all information about a single meal plan as JSON.

### Acceptance Criteria

- The webserver features a request URL featuring a GET parameter, which allows to request
  information about a specific meal plan as JSON
- The webserver responds with JSON data if the correct request header is set

### Implementation

> An API endpoint is implemented in ```/public/api.php```.<br>
> In the backend ```/src/Api/GetMeals.php``` is implemented to get the Meals that the seeder is generating.
>
> - http://localhost:8080/api.php?id={mealID} displays a single meal with the corresponding ID.
> - http://localhost:8080/api.php?all=true displays all the meals.
>
> #### api.php
> - The api checks for "id" or "all" in $_GET and calls the corresponding GetMeals.php methode.
> #### GetMeals.php
> - The GetMeals.php uses the seeder to generate the data and displays it as JSON.

## User Story 4

> As a Developer I want to fetch all data from the meal plan service and display it as a list on a page.

### Acceptance Criteria

- The JavaScript "fetch" function is used to fetch the data from the created API
- The full dataset is displayed on the page

### Implementation

# Weiterarbeiten!!!!

## User Story 5

> As a Parent I want to have a single meal displayed on the screen prominently, featuring title, allergens,
> and description, so that I can identify the relevant information quickly.

### Acceptance Criteria

- A single meal entry is displayed on the page
- The page is responsive
- The page follows the heuristics for user interface design of Jakob Nielsen

### Implementation

## User Story 6

> As a Developer I want to implement JWT token validation for API endpoints, so that only authenticated
> users can access protected resources.

### Acceptance Criteria

- The API checks for the presence of a JWT token in the Authorization header
- Invalid or missing tokens return a 401 Unauthorized response
- Only requests with valid JWT tokens receive the requested data
- Token expiration is properly handled and returns appropriate error messages
- The implementation includes proper error logging for security monitoring

#### US3

With http://localhost:8080/api.php?id=X you can request information about a specific meal plan as JSON.

#### US4

At http://localhost:8080 you can see all mealplans via js.

#### US5

Using the get parameter "id" you can request a meal with that id at http://localhost:8080

#### US6
