<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        DB::table('users')->insert([
            'username' => 'user1',
            'email' => 'user1@email.com',
            'password' => Hash::make('secret'),
            'photo' => url('images/avatar-df.jpg'),
            'created_at' => \Carbon\Carbon::now('Asia/Jakarta')
        ]);
    }
}
