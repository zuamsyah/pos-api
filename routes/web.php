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
//secure url
URL::forceScheme('https');

$router->get('/', function () use ($router) {
    return $router->app->version();
});
$router->group(['prefix' => 'api/v1'], function() use ($router) {
	$router->post('auth/login', 'AuthController@login');
	$router->post('auth/register', 'AuthController@register');
	$router->group(['middleware' => 'jwt.auth'], function () use ($router) {
		//user
		$router->get('account/profile', 'UserController@profile');
		$router->patch('account/changepassword', 'AuthController@changepassword');
        $router->patch('account/profile/update', 'UserController@update');
        $router->post('account/uploadphoto', 'UserController@uploadPhoto');
        $router->post('logout', 'AuthController@logout');
		//category
		$router->get('category', 'CategoriesController@index');
		$router->post('category', 'CategoriesController@store');
		$router->delete('category/{id}', 'CategoriesController@destroy');
		//product
	    $router->get('product', 'ProductController@index');
      	$router->get('product/{id}', 'ProductController@show');
      	$router->get('p/search', 'ProductController@searchDataProduct');
		$router->patch('product/{id}', 'ProductController@update');
		$router->post('product', 'ProductController@store');
      	$router->delete('product/{id}', 'ProductController@destroy');
      	
      	$router->get('city', 'CustomerController@allCity');

      	//customer
		$router->get('customer', 'CustomerController@index');
		$router->get('customer/{id}', 'CustomerController@show');
      	$router->post('customer', 'CustomerController@store');
      	$router->patch('customer/{id}', 'CustomerController@update');
      	$router->delete('customer/{id}', 'CustomerController@destroy');
      	//supplier
		$router->get('supplier', 'SupplierController@index');
		$router->get('supplier/{id}', 'SupplierController@show');  
      	$router->post('supplier', 'SupplierController@store');
      	$router->patch('supplier/{id}', 'SupplierController@update');
      	$router->delete('supplier/{id}', 'SupplierController@destroy');
      	//transaksi
		$router->get('pembelian', 'OrderController@index');
		$router->get('pembelian/{id}', 'OrderController@show');
      	$router->post('pembelian', 'OrderController@store');
		$router->patch('pembelian/{id}', 'OrderController@update');

		$router->get('penjualan', 'SalesController@index');
      	$router->post('penjualan', 'SalesController@store');
		$router->patch('penjualan/{id}', 'SalesController@update');
		//laporan
		$router->get('laporanpembelianhari', 'ReportController@getDayOrderReport');
		$router->get('laporanpembelianbulan', 'ReportController@getMonthOrderReport');
		$router->get('laporanpenjualanhari', 'ReportController@getDaySalesReport');
		$router->get('laporanpenjualanbulan', 'ReportController@getMonthSalesReport');
		$router->get('laporanstokbaranghari', 'ReportController@getDayStockReport');
		$router->get('laporanstokbarangbulan', 'ReportController@getMonthStockReport');
		$router->get('laporanmutasibaranghari', 'ReportController@getDayMutationReport');
		$router->get('laporanmutasibarangbulan', 'ReportController@getMonthMutationReport');
	});
});
