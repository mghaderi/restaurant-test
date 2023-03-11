
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

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
