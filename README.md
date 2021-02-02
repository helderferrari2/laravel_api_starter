# LARAVEL-API-STARTER

This repository contains the **_api_** , a base project to construct an API.

## Prerequisites

-   [laravel](http://laravel.com/)

## Installation

1. Clone the **_this repository_** to a location on your file system.
2. `cd` into the directoy, run `composer install`.
3. Copy `.env.example` to `.env`
4. Edit the `.env`, configure the database credentials
5. Run `php artisan key:generate`
6. Run the migrations `php artisan migrate:fresh --seed` to create tables in database
7. Run `php artisan serve` to start the server.
8. Navigate to `localhost:8000` in your browser.

## TDD

Open terminal an type
`vendor\bin\phpunit`
