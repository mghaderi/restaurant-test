
## Instalation
I used Laravel framwork with sail.
- Clone the project.
- Run the following command at the root of project:
```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs
```
Now you shold have access to sail
- Run the following command for making mysql, app and redis containers.
```
./vendor/bin/sail up

```
Make sure your system  80, 6379 and 3306 ports are free. otherwise you nee to change these ports in docker-compose.yml file.
- After containers has been created successfully, run the following commands.
```
./vendor/bin/sail artisan migrate
./vendor/bin/sail db:seed
```
By Seeding database, some samples will be added to vendors, users and other tables to fulfill assumptions that declared in the task.
- After seeding, there should be 25 records in orders table:
    - 1 to 5 are orders which still have time, and no trip assigned to them yet.
    - 6 to 10 are orders which still have time and each one has a trip with random status
    - 11 to 15 are orders which does not have any remaining time and there is no trip for them
    - 16 to 20 are orders which does not have any remaining time, but there is a trip for each of them with a random status which is not "delivered" (it should be one of these: assigned, at_vendor, picked)
    - 20 to 25 are orders which does not have any remaining time, but there is a trip for each of them a "delivered" status
I think generated orders should cover all possibilities that could happen.
- After seeding, there should be 5 employees in users table with ids: [101,102,103,104,105]
- 4 routes added to this project, that could be called with mentioned order and employee ids.
## Routes
- There is no authentication for any of the routes.
- A postman collection attached to response email, which cantains these routes.
- Please set Accept header in requsts with "application/json"
- First route is for submitting a delay in order
    - address: 127.0.0.1/api/order/delay (post)
    -input sample: (json)
    ```
    {
        "order_id": 22
    }
    ```
This route check the order, base on it's conditions, it may do none, one or some of below things:
    - update order
    - add it to delay reports
    - add it to delay orders
Then it will return proper response.
- Second route is for assigning employee an order which is in delay orders
    - address: 127.0.0.1/api/order/assign (post)
    - input sample: (json)
    ```
    {
        "employee_id": 101
    }
    ```
If employee exists and is not busy with another order, and there is some orders in delay orders which no employee has taken yet, it will assign that order to employee and return proper response.
- Third route is for freeing employee from order and consider order to be resolved (after an order resolved, it could be again added to delay process with first method)
    - address: 127.0.0.1/api/order/resolve (post)
    - input sample: (json)
    ```
    {
        "employee_id": 101
    }
    ```
-Fourth route is for reporting vendors with delayed orders within current week, ordered by vendors with most delay orders to less ones.
    -address: 127.0.0.1/api/order/report (get)
    -no input

Thank you for your time.
