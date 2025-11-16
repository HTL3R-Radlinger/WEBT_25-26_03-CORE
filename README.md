At first install run: ```docker compose up --build -d```

Then go into the container: ```docker exec -it CORE3 bash```. And run ```composer install``` (This creates the vendor
folder)

With http://localhost:8080/demo.php you can see the demo.