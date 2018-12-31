<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

//generate key
$router->get('/key', function() {
    return str_random(32);
});

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api/v1'], function() use ($router) {
	$router->post('auth/login', 'AuthController@login');
	$router->post('auth/register', 'AuthController@register');
	$router->group(['middleware' => 'jwt.auth'], function () use ($router) {
		//user
		$router->get('account/profile', 'UserController@profile');
		$router->patch('account/updatepassword', 'AuthController@updatePassword');
        $router->patch('account/profile', 'UserController@update');
        $router->post('account/uploadphoto', 'UserController@uploadPhoto');
        $router->post('logout', 'AuthController@logout');
		//category
		$router->get('category', 'CategoriesController@index');
		$router->post('category', 'CategoriesController@store');
		$router->delete('category/{id}', 'CategoriesController@destroy');
		//product
	    $router->get('products', 'ProductController@index');
      	$router->get('products/{id}', 'ProductController@show');
      	$router->get('search', 'ProductController@searchDataProduct');
		$router->post('products', 'ProductController@store');
		$router->patch('products/{id}', 'ProductController@update');
      	$router->delete('products/{id}', 'ProductController@destroy');
      	
      	$router->get('cities', 'CustomerController@allCity');

      	//customer
		$router->get('customers', 'CustomerController@index');
		$router->get('customers/{id}', 'CustomerController@show');
      	$router->post('customers', 'CustomerController@store');
      	$router->patch('customers/{id}', 'CustomerController@update');
      	$router->delete('customers/{id}', 'CustomerController@destroy');
      	//supplier
		$router->get('suppliers', 'SupplierController@index');
		$router->get('suppliers/{id}', 'SupplierController@show');  
      	$router->post('suppliers', 'SupplierController@store');
      	$router->patch('suppliers/{id}', 'SupplierController@update');
      	$router->delete('suppliers/{id}', 'SupplierController@destroy');
      	//transaction
		$router->get('purchases', 'OrderController@index');
		$router->get('purchases/{id}', 'OrderController@show');
      	$router->post('purchases', 'OrderController@store');

		$router->get('sales', 'SalesController@index');
		$router->get('sales/{id}', 'SalesController@show');
		$router->post('sales', 'SalesController@store');
		//report
		$router->get('purchasereport/daily', 'ReportController@getDayOrderReport');
		$router->get('purchasereport/monthly', 'ReportController@getMonthOrderReport');
		$router->get('salesreport/daily', 'ReportController@getDaySalesReport');
		$router->get('salesreport/monthly', 'ReportController@getMonthSalesReport');
		$router->get('stockreport/daily', 'ReportController@getDayStockReport');
		$router->get('stockreport/monthly', 'ReportController@getMonthStockReport');
		$router->get('mutationreport/daily', 'ReportController@getDayMutationReport');
		$router->get('mutationreport/monthly', 'ReportController@getMonthMutationReport');
	});
});
