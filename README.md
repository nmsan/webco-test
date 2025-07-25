# Local Setup with Laravel Sail

## Prerequisites
- Docker Desktop installed on your machine
- Docker Compose
- Git
- PHP 8^
- php composer 2^
## Initial Setup

1. **Clone the Repository**
2. **Navigate to the project folder**
3. **run composer update**
4. **create sqlite database touch database/database.sqlite**
5. **make sure .env precent and ASMORPHIC_USERNAME and ASMORPHIC_PASSWORD are added to the .env**
2. **run ./vendor/bin/sail up -d**
3. **run ./vendor/bin/sail artisan migrate --seed**
5. **run ./vendor/bin/sail artisan make:filament-user**
6. **run ./vendor/bin/sail artisan queue:work** 
6. http://localhost/admin


## Demo
https://webco-test-main-08jreg.laravel.cloud/admin/login
