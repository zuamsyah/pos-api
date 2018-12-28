# REST API with Lumen

[![Build Status](https://travis-ci.org/laravel/lumen-framework.svg)](https://travis-ci.org/laravel/lumen-framework)
[![Total Downloads](https://poser.pugx.org/laravel/lumen-framework/d/total.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/lumen-framework/v/stable.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/lumen-framework/v/unstable.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![License](https://poser.pugx.org/laravel/lumen-framework/license.svg)](https://packagist.org/packages/laravel/lumen-framework)

Penjualanapp RESTful API for Lumen micro-framework. Features included:

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
- RESTful routing
- PostgreSQL Database

## Routes List:

### Auth

| HTTP Method	| Path | Action | Scope | Desciption  |
| ----------- | ---- | ------ | ----- | ----------- |
| `POST`      | `api/v1/auth/register` | `register` | `users:create` | `Create an user` |


## License

The Lumen framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
