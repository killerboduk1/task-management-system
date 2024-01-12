## Task Management System

## Installation

- clone the repo https://github.com/killerboduk1/task-management-system
- cd to task-management-system
- rename or copy .env.example to .env then update your Database credentials
- runs these commands

```bash
composer install
npm install
php artisan migrate
php artisan storage:link
```
- run these to generate the key
```bash
php artisan key:generate
php artisan optimize
php artisan config:cache
```
- And then run the server
```bash 
php artisan serve
```

 ## Features

- Authentication login / register
- can add Task, edit, update, delete, retore deleted task and delete permanently.
- can add Sub task edit, update, delete
- can add image on a Task

 ## Version used as per the requirements 

- Laravel 8.0 
- PHP 7.4 
- plain laravel blade templates
