
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
- There is not authentication for any of the routes.
## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
