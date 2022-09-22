<?php

use Illuminate\Database\Seeder;
use App\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            [
                'created_by' => 1,
                'name' => 'Apple Watch',
                'brand' => 'Apple',
                'discription' => 'Brand New',
                'image' => 'apple3.jpg',
                'price' => 80000
            ],

            [
                'created_by' => 1,
                'name' => 'Apple IPhone 12',
                'brand' => 'Apple',
                'discription' => 'Brand New',
                'image' => 'iphone12.jpg',
                'price' => 2200000
            ],

            [
                'created_by' => 1,
                'name' => 'Apple IPhone X',
                'brand' => 'Apple',
                'discription' => 'Brand New',
                'image' => 'iphonex.jpg',
                'price' => 100000

            ],

            [
                'created_by' => 1,
                'name' => 'VR Headset',
                'brand' => 'Samsung',
                'discription' => 'Brand New',
                'image' => 'VR.jpg',
                'price' => 20000
            ]
        ];


        foreach ($products as $key => $value) {
            Product::create($value);
        }

    }
}
