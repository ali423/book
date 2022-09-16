This project dockerized using laravel sail and to run it, 
you can use the << ./vendor/bin/sail up >> command.
In this project, authorized users with JWT tokens are done using passport , 
so first you should run database migration and seeders using << php artisan migrte:fresh –seed >> 
and then create a personal access client using << php artisan passport:client --personal >> command
This project cache driver is configured on Redis.
This project includes unit and integration tests, so for the test route automatically you can use <<php artisan test >>
This project test database is configured on SQLite.
