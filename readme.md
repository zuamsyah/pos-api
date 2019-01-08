# REST API with Lumen

[![Build Status](https://travis-ci.org/laravel/lumen-framework.svg)](https://travis-ci.org/laravel/lumen-framework)
[![Total Downloads](https://poser.pugx.org/laravel/lumen-framework/d/total.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/lumen-framework/v/stable.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/lumen-framework/v/unstable.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![License](https://poser.pugx.org/laravel/lumen-framework/license.svg)](https://packagist.org/packages/laravel/lumen-framework)

Penjualanapp RESTful API for Lumen micro-framework.

## Features

- Validation
- JWT Authentication
- Models with proper relationships
- API Response with [Fractal](http://fractal.thephpleague.com/)
- Pagination
- Seeding Database
- Error Handling
- [CORS](https://github.com/barryvdh/laravel-cors) Support
- Endpoint Tests and Unit Tests
- Postman Collection
- RESTful routing
- Filter data
- Custom respond function
- PostgreSQL Database

## Requirements

- PostgreSQL
- PDO Driver PGSQL
- PHP >=7.2
- Composer
- Apache service
- Postman

## Installation

- `git clone https://github.com/zuams/API-PenjualanApp.git`
- `cd API-PenjualanApp`
- `cp .env.example .env`
- `composer install`
- Since Lumen doesn't have the php artisan key:generate command, there's a custom route http://localhost:8000/key to help you generate an application key. Copy key to `APP_KEY`
- `php artisan jwt:secret` and Set to your`JWT_SECRET`
- Copy your API KEY Rajaongkir to `RAJAONGKIR_API_KEY`
- Set your PostgreSQL connection details 
- `php artisan migrate --seed`
- `php -S localhost:8000 -t public`
- Postman collection link https://www.getpostman.com/collections/002a7a8f9d37d4e1ecb8

## API Documentation
  ### Swagger docs
   - https://penjualanapp-api.herokuapp.com/swagger
  ### Postman docs
   - https://documenter.getpostman.com/view/4436296/RznBMzh1


## License

The Lumen framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
