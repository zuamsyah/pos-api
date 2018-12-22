<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\User::create([
	        'username'  => str_random(20),
	        'email' => str_random(10) . '@demo.com',
	        'password'  => Hash::make('secret')
		]);
    }
}
