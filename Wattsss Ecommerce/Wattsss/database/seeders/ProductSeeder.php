<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define products data with associated category IDs
        $products = [
            [
                'category_id' => 1, // Example category ID
                'name' => 'TCL TWF75 P60',
                'price' => 20995.00,
                'image' => 'images/cat1-prod1.png',
            ],
            [
                'category_id' => 1, // Example category ID
                'name' => 'Whirlpool WWEB11703BG',
                'price' => 49998.00,
                'image' => 'images/cat1-prod2.png',
            ],
            [
                'category_id' => 1, // Example category ID
                'name' => 'Maytag MDG20MNAWW',
                'price' => 62950.00,
                'image' => 'images/cat1-prod3.png',
            ],
            [
                'category_id' => 2, // Example category ID
                'name' => 'Bespoke Refrigerator TMF RT38CB66228A AI Energy 13.9 cu.ft. Clean White + Clean Navy',
                'price' => 39749.00,
                'image' => 'images/cat2-prod1.png',
            ],
            [
                'category_id' => 2, // Example category ID
                'name' => 'Refrigerator SBS RS64T5F01B4 Family Hub™ 23.2 cu.ft. Gentle Black Matt',
                'price' => 158817.00,
                'image' => 'images/cat2-prod2.png',
            ],
            [
                'category_id' => 2, // Example category ID
                'name' => 'Bespoke Refrigerator FDR RF65DB90B022 Triple Cooling 24.0 cu.ft. Clean Black',
                'price' => 115936.00,
                'image' => 'images/cat2-prod3.png',
            ],
            [
                'category_id' => 3, // Example category ID
                'name' => 'BES500 BREVILLE BAMBINO PLUS COFFEE MACHINE',
                'price' => 36535.00,
                'image' => 'images/cat3-prod1.png',
            ],
            [
                'category_id' => 3, // Example category ID
                'name' => 'ICM-512AS IMARFLEX 12CUPS COFFEEMAKER',
                'price' => 1990.00,
                'image' => 'images/cat3-prod2.png',
            ],
            [
                'category_id' => 3, // Example category ID
                'name' => 'KKM1001R KOIZUMI GRIND AND BREW COFFEMAKER',
                'price' => 7416.00,
                'image' => 'images/cat3-prod3.png',
            ],
            [
                'category_id' => 4, // Example category ID
                'name' => 'Samsung MC35R8088LC 35 Liters Smart Microwave Oven',
                'price' => 22795.00,
                'image' => 'images/cat4-prod1.png',
            ],
            [
                'category_id' => 4, // Example category ID
                'name' => 'American Home AMW-22W 20 Liters Microwave Oven',
                'price' => 2829.00,
                'image' => 'images/cat4-prod2.png',
            ],
            [
                'category_id' => 4, // Example category ID
                'name' => 'Whirlpool MWP-253 SX 25 Liters Microwave',
                'price' => 5998.00,
                'image' => 'images/cat4-prod3.png',
            ],
            [
                'category_id' => 5, // Example category ID
                'name' => '3D MX-250H 5-Speed Hand Mixer',
                'price' => 1079.00,
                'image' => 'images/cat5-prod1.png',
            ],
            [
                'category_id' => 5, // Example category ID
                'name' => 'Imarflex IMX-270B Electric Hand Mixer Black',
                'price' => 1599.00,
                'image' => 'images/cat5-prod2.png',
            ],
            [
                'category_id' => 5, // Example category ID
                'name' => 'Imarflex IMX-250 Portable Hand Mixer',
                'price' => 1288.00,
                'image' => 'images/cat5-prod3.png',
            ],
            [
                'category_id' => 6, // Example category ID
                'name' => 'Panasonic CS/CU-PU24AKQ',
                'price' => 62998.00,
                'image' => 'images/cat6-prod1.png',
            ],
            [
                'category_id' => 6, // Example category ID
                'name' => 'Condura CDH020D3W0',
                'price' => 10998.00,
                'image' => 'images/cat6-prod2.png',
            ],
            [
                'category_id' => 6, // Example category ID
                'name' => 'Midea FP-51ARA005HMNV-N5',
                'price' => 8458.00,
                'image' => 'images/cat6-prod3.png',
            ],
            [
                'category_id' => 7, // Example category ID
                'name' => 'Dowell TF3-217 Red',
                'price' => 1198.00,
                'image' => 'images/cat7-prod1.png',
            ],
            [
                'category_id' => 7, // Example category ID
                'name' => 'Dowell TF-200UP',
                'price' => 1298.00,
                'image' => 'images/cat7-prod2.png',
            ],
            [
                'category_id' => 7, // Example category ID
                'name' => 'Asahi CF-833 Black',
                'price' => 3098.00,
                'image' => 'images/cat7-prod3.png',
            ],
            // Add more products as needed
        ];

        // Iterate over products data and create products
        foreach ($products as $productData) {
            Product::create($productData);
        }
    }
}
