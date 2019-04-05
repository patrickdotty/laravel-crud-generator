# Laravel CRUD generator

This package was created mainly for Dottystyle developers. The function of this package
is to scaffold the very basic purpose of a CRUD. It creates the following:

* Controller
* Model
* Resource
* Request

## Installation
1. Install the package

        $ composer require dottystyle/laravel-crud-generator

2. Publish vendor

        $ php artisan vendor:publish --provider="Dottystyle\LaravelCrudGenerator\Providers\LaravelCrudGeneratorServiceProvider"

3. Edit config/app.php (Add the following)

        service provider:
        Dottystyle\LaravelCrudGenerator\Providers\LaravelCrudGeneratorServiceProvider::class,

## Using this package

1. Building CRUD for api resources

        $ php artisan make:crud --api

2. Building a simple CRUD

        $ php artisan make:crud