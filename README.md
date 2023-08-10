# Laravel Simple Permissions

Laravel Simple Permissions is a lightweight library designed to simplify permissions management in Laravel projects.

## Features

- Easily integrate permissions into your Laravel application.
- Assign and validate permissions on users.
- Supports Laravel's built-in user authentication system.

## Requirements

- PHP >= 7.3
- Laravel >= 8.0
- Laravel Breeze (Laravel's authentication features)

## Installation

Laravel Simple Permissions works with Laravel's authentication features. Please install this before install Laravel Simple Permissions. You can follow instructions here: https://laravel.com/docs/10.x/starter-kits#laravel-breeze

You can install the package via composer:

```bash
composer require pedrazadixon/laravel-simple-permissions
```

Finish the installation with the following command:

```bash
php artisan laravel-simple-permissions:install
```

## Usage

### Add **permissions** middleware to routes, for example:
```php
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'permissions'])->name('dashboard');
```


### Creating permissions

You can create permissions navigate the following route:

- http://your-app.test/roles


### Publish views (optional)

You can publish the views with:

```bash
php artisan vendor:publish --tag=laravel-simple-permissions-views
```