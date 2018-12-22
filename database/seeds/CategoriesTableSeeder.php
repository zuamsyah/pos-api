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
    	App\Categories::insert([
    		['category_name' => 'Pakaian'],
    		['category_name' => 'Makanan'],
    		['category_name' => 'Alat Tulis'],
    		['category_name' => 'Kendaraan'],
    		['category_name' => 'Elektronik'],
    		['category_name' => 'Mainan'],
    		['category_name' => 'Kamera'],
    		['category_name' => 'Sepeda'],
    		['category_name' => 'Mobil'],
    		['category_name' => 'Buku'],
    	]);
    }
}
