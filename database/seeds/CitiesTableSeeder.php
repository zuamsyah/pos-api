<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = city::all();
      	foreach ($data as $city) {
  			DB::table('cities')->insert([
  				'name' => $city->city_name,
  			]);
      	}
    }
}
