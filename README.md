Sistem Gudang ID Grow by Klaus Rajendra Wastu

1. Install laravel 11
   -- composer create-project --prefer-dist laravel/laravel sistem-gudang3

2. Set database configuration at .env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=gudang -> database name
   DB_USERNAME=root
   DB_PASSWORD=12345678 -> password root mysql

3. Enable API and Update Authentication Exception
   -- php artisan install:api
   update the authentication exception of our API middleware atbootsrap/app.php

4. Install and Setup JWT Auth package
   -- composer require php-open-source-saver/jwt-auth

    publish package config file for JWTAuth
    -- php artisan vendor:--provider="PHPOpenSourceSaver\JWTAuth\Providers\LaravelServiceProvider"

    geneerate secret key
    -- php artisan jwt:secret

    update auth guard config at config/auth.php

5. Update User Model and implement getJWTIdentifier() and getJWTCUstomClaims() methods

6. Create migrations & Model category, location, item and mutation
   -- php artisan make:migrations name_of_table

7. Create controller category, location, item and mutation
   -- php artisan make:controller name_of_controller

8. Register all routes using middleware authentication

9. Run the app
   -- php artisan serve

Link Postman
-- https://documenter.getpostman.com/view/25757044/2sAXjRXAVm
