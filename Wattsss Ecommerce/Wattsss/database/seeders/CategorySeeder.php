<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
            [
                'name' => 'Washing Machine',
                'image' => "images/cat-1.png",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Refrigerator',
                'image' => "images/cat-2.png",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Coffee Maker',
                'image' => "images/cat-3.png",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Microwave Oven',
                'image' => "images/cat-4.png",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Handmixer',
                'image' => "images/cat-5.png",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Aircon',
                'image' => "images/cat-6.png",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Electric Fan',
                'image' => "images/cat-7.png",
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
