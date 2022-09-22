<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'created_by' => 1,
            'title' => 'Electronics',
        ]);
        DB::table('categories')->insert([
            'created_by' => 1,
            'title' => 'Watches',
        ]);
    }
}
