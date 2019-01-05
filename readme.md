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

## Routes List:

### Authentication

| HTTP Method	| Path | Action | Scope | Desciption  |
| ----------- | ---- | ------ | ----- | ----------- |
| `POST`      | `api/v1/auth/register` | `register` | `users:create` | `Create an user` |
| `POST`      | `api/v1/auth/login`    | `login`    | `users:create` | `Login an user`  |
| `POST`      | `api/v1/auth/logout`   | `logout`   | `users:delete` | `Delete an token`|

### Users

| HTTP Method	| Path | Action | Scope | Desciption  |
| ----------- | ---- | ------ | ----- | ----------- |
| `GET`       | `api/v1/account/profile`        | `profile` | `users:list`  | `Get user`       |
| `PATCH`     | `api/v1/account/profile` | `update`  | `users:write` | `Update an user` |
| `PATCH`     | `api/v1/account/updatepassword` | `updatePassword` | `users:write` | `Update an user password` |
| `POST`      | `api/v1/account/uploadphoto`    | `uploadPhoto`    | `users:create` | `Upload an user photo` |

### Product

| HTTP Method	| Path | Action | Scope | Desciption  |
| ----------- | ---- | ------ | ----- | ----------- |
| `GET`       | `api/v1/products`     | `index` | `product:list` | `Get all product`        |
| `GET`       | `api/v1/products/{product}`| `show`  | `product:read` | `Fetch an product by id` |
| `GET`       | `api/v1/search`     | `searchDataProduct` | `product:read` | `Fetch an product by param` |
| `POST`      | `api/v1/products`     | `store`   | `product:create` | `Create an product` |
| `PATCH`     | `api/v1/products/{product}`| `update`  | `product:write`  | `Update an product by id` |
| `DELETE`    | `api/v1/product/{product}` | `destroy` | `product:delete` | `Delete an product by id` |

### Category

| HTTP Method	| Path | Action | Scope | Desciption  |
| ----------- | ---- | ------ | ----- | ----------- |
| `GET`       | `api/v1/category`     | `index`  | `category:list`   | `Get all category`   |
| `POST`      | `api/v1/category`     | `store`  | `category:create` | `Create an category` |
| `DELETE`    | `api/v1/category/{category}`| `destroy`| `category:delete` | `Delete an category by id` |

### Customer

| HTTP Method	| Path | Action | Scope | Desciption  |
| ----------- | ---- | ------ | ----- | ----------- |
| `GET`       | `api/v1/customers`     | `index`  | `customer:list`   | `Get all customer`   |
| `GET`       | `api/v1/customers/{customer}`| `show`   | `customer:read`   | `Fetch an customer by id`|
| `POST`      | `api/v1/customers`     | `store`  | `customer:create` | `Create an customer` |
| `PATCH`     | `api/v1/customers/{customer}`| `update` | `customer:write`  | `Update an customer by id` |
| `DELETE`    | `api/v1/customers/{customer}`| `destroy`| `customer:delete` | `Delete an customer by id` |

### Supplier

| HTTP Method	| Path | Action | Scope | Desciption  |
| ----------- | ---- | ------ | ----- | ----------- |
| `GET`       | `api/v1/suppliers`     | `index`  | `supplier:list`   | `Get all supplier`   |
| `GET`       | `api/v1/suppliers/{supplier}`| `show`   | `supplier:read`   | `Fetch an supplier by id`|
| `POST`      | `api/v1/suppliers`     | `store`  | `supplier:create` | `Create an supplier` |
| `PATCH`     | `api/v1/suppliers/{supplier}`| `update` | `supplier:write`  | `Update an supplier by id` |
| `DELETE`    | `api/v1/suppliers/{supplier}`| `destroy`| `supplier:delete` | `Delete an supplier by id` |

### City

| HTTP Method	| Path | Action | Scope | Desciption  |
| ----------- | ---- | ------ | ----- | ----------- |
| `GET`       | `api/v1/cities` | `allCity` | `city:list` | `Get all city` |

### Purchase
| HTTP Method	| Path | Action | Scope | Desciption  |
| ----------- | ---- | ------ | ----- | ----------- |
| `GET`       | `api/v1/purchases`     | `index`  | `purchase:list`   | `Get all purchase` |
| `GET`       | `api/v1/purchases/{purchase}`| `show`   | `purchase:read`   | `Fetch an purchase by id` |
| `POST`      | `api/v1/purchases`     | `store`  | `purchase:create` | `Create an purchase` |

### Sales
| HTTP Method	| Path | Action | Scope | Desciption  |
| ----------- | ---- | ------ | ----- | ----------- |
| `GET`       | `api/v1/sales`      | `index` | `sales:list`  | `Get all sales` |
| `GET`       | `api/v1/sales/{sale}` | `show`  | `sales:read`  | `Fetch an sales by id` |
| `POST`      | `api/v1/sales`      | `store` | `sales:create`| `Create an sales` |

### Report
| HTTP Method	| Path | Action | Scope | Desciption  |
| ----------- | ---- | ------ | ----- | ----------- |
| `GET`       | `api/v1/purchasereport/daily` | `getDayOrderReport` | `report:list` | `Get all purchase report by param` |
| `GET`       | `api/v1/purchasereport/monthly` | `getMonthOrderReport` | `report:list` | `Get all purchase report by param` |
| `GET`       | `api/v1/salesreport/daily` | `getDaySalesReport` | `report:list` | `Get all sales report by param` |
| `GET`       | `api/v1/salesreport/monthly` | `getMonthSalesReport` | `report:list` | `Get all sales report by param` |
| `GET`       | `api/v1/stockreport/daily` | `getDayStockReport` | `report:list` | `Get all stock report by param` |
| `GET`       | `api/v1/stockreport/monthly` | `getMonthStockReport` | `report:list` | `Get all stock report by param` |
| `GET`       | `api/v1/mutationreport/daily` | `getDayMutationReport` | `report:list` | `Get all mutation report by param` |
| `GET`       | `api/v1/mutationreport/monthly` | `getMonthMutationReport` | `report:list` | `Get all mutation report by param` |

## License

The Lumen framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
