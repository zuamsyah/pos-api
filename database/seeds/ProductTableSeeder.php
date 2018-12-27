<?php

use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Product::insert([
        	[
        		'product_code'=> 'AR91237',
        		'user_id' => 1,
			    'product_name'=> 'Asus ROG Zeph2yrus GX501GI-XS74',
			    'category_id'=> 5,
			    'first_stock'=> 10,
			    'total_stock'=> 10,
			    'buy_price'=> '37079860',
			    'sell_price'=> '38079860',
			    'unit'=> 'box',
		     	'created_at' => \Carbon\Carbon::now('Asia/Jakarta')
        	],
        	[
        		'product_code'=> 'AP91222',
        		'user_id' => 1,
			    'product_name'=> 'Acer Predator 15 G9-593-73N6',
			    'category_id'=> 5,
			    'first_stock'=> 15,
			    'total_stock'=> 15,
			    'buy_price'=> '28322000',
			    'sell_price'=> '25322000',
			    'unit'=> 'box',
		     	'created_at' => \Carbon\Carbon::now('Asia/Jakarta')
        	],
        	[
        		'product_code'=> 'SM38128',
        		'user_id' => 1,
			    'product_name'=> 'Samsung - Galaxy S9 64GB',
			    'category_id'=> 5,
			    'first_stock'=> 8,
			    'total_stock'=> 8,
			    'buy_price'=> '6270000',
			    'sell_price'=> '7979860',
			    'unit'=> 'dus',
		     	'created_at' => \Carbon\Carbon::now('Asia/Jakarta')
        	],
        ]);
    }
}
