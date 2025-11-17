At first install run: ```docker compose up --build -d```

Then go into the container: ```docker exec -it CORE3 bash```. And run ```composer install``` (This creates the vendor
folder)

#### US2
With http://localhost:8080/demo.php you can see the demo.

#### US3
With http://localhost:8080/api.php?id=X you can request information about a specific meal plan as JSON.

#### US4
At ```http://localhost:8080``` you can see all mealplans via js.

#### US5
Using the get parameter "id" you can request a meal with that id at ```http://localhost:8080```