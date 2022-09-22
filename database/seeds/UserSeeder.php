<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin Shahzaib',
            'email' => 'admin@admin.com',
            'phone' => '098767654',
            'address' => 'Main coly , strat no. 777 , pakistan',
            'role' => 'admin',
            'email_verified_at'=> '2022-06-30 23:41:05',
            'password' => Hash::make('12345678'),
        ]);
        DB::table('users')->insert([
            'name' => 'Customer Shahzaib',
            'email' => 'customer@customer.com',
            'phone' => '098767654',
            'address' => 'Main coly , strat no. 777 , pakistan',
            'role' => 'customer',
            'email_verified_at'=> '2022-06-30 23:44:05',
            'password' => Hash::make('12345678'),
        ]);
    }
}
