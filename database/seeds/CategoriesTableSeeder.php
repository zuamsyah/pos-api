<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	App\Models\Categories::insert([
    		['category_name' => 'Pakaian', 'user_id' => 1,],
    		['category_name' => 'Makanan', 'user_id' => 1,],
    		['category_name' => 'Alat Tulis', 'user_id' => 1,],
    		['category_name' => 'Kendaraan', 'user_id' => 1,],
    		['category_name' => 'Elektronik', 'user_id' => 1,],
    		['category_name' => 'Mainan', 'user_id' => 1,],
    		['category_name' => 'Kamera', 'user_id' => 1,],
    		['category_name' => 'Sepeda', 'user_id' => 1,],
    		['category_name' => 'Mobil', 'user_id' => 1,],
			['category_name' => 'Buku', 'user_id' => 1,],
			['category_name' => 'Susu', 'user_id' => 1,],
    	]);
    }
}
