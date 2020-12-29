# simple-crud-laravel-vue

## How it works
Serve both of projects

## Laravel
`git clone https://github.com/andydptyo/simple-crud-laravel-vue.git`

`cd simple-crud-laravel-vue && cd laravel`

`composer install`

`cp .env.example .env`

open `.env` then edit `DB_DATABASE,DB_USERNAME,DB_PASSWORD` according to yours

`php artisan key:generate`

`php artisan migrate:fresh --seed` to seed administrator user

`php artisan serve` it will run in `localhost:8000`

## Vue
go to vue-cli folder

`npm install` or `yarn`

`yarn serve` it will run in `localhost:8080`

open `localhost:8080` in a browser

## Seed
Email : admin@superhelper.id

Password : 123456789
