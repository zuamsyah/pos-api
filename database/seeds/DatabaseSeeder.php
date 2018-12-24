<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call('UserTableSeeder');
        $this->call('CategoriesTableSeeder');
        $this->call('ProductTableSeeder');
        $this->call('CitiesTableSeeder');
        $this->call('SupplierTableSeeder');
        $this->call('CustomerTableSeeder');
    }
}
