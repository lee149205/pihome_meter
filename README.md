# Instruction

## Overview
- PiHome Meter source code.
- Written by Laravel

## Requirements
- PHP >= 7.2
- OpenSSL PHP Extension
- PDO PHP Extension
- Composer
- MySql
- Git
- Elasticsearch
- Redis

## Install project
- Clone project `git clone https://github.com/futechco/pihome_meter.git`
- Edit /etc/hosts `127.0.0.1 api.meter`
- Config environment in .env file
```
    php -r "file_exists('.env') || copy('./.env.example', '.env');"
```
```
    APP_ENV=dev
    APP_URL=http://api.meter
    APP_VERSION=v1
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=pihome_meter
    DB_USERNAME=root
    DB_PASSWORD=
    MAIL_USERNAME=
    MAIL_PASSWORD=
    MAIL_FROM_ADDRESS=no-reply@pihome.com
    REDIS_HOST=127.0.0.1
    REDIS_PASSWORD=null
    REDIS_PORT=6379
    REDIS_PREFIX=pihome_meter_
    BROADCAST_DRIVER=redis
    CACHE_DRIVER=redis
    JWT_KEY=
```
- generate vendor folder folder
    `composer install`

- create database with name "pihome_meter"

- generate tables and seed   
    ```
  php artisan config:clear
  php artisan cache:clear
  php artisan key:generate --ansi
  php artisan migrate  
  php artisan db:seed
  php artisan storage:link
  ```

## Start with docker
  - install container
  ```
      docker-compose build --no-cache
      docker-compose up
      docker-compose exec php sh ./docker/install.sh 
  ```
