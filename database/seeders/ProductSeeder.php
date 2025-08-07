<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * BEGINNER EXPLANATION:
     * This seeder creates sample cookie products in the database.
     * Run this with: php artisan db:seed --class=ProductSeeder
     */
    public function run(): void
    {
        // BEGINNER EXPLANATION:
        // This array contains all the cookie data we want to add to our store
        $products = [
            [
                'name' => 'Classic Chocolate Chip',
                'description' => 'Our signature cookie made with premium chocolate chips and a hint of vanilla. Soft, chewy, and absolutely irresistible!',
                'price' => 2.99,
                'image' => 'chocolate-chip.jpg', // You can add actual images to public/images/
                'is_active' => true,
                'stock_quantity' => 50
            ],
            [
                'name' => 'Double Fudge Brownie',
                'description' => 'Rich, decadent brownie cookie loaded with chocolate chunks. Perfect for serious chocolate lovers!',
                'price' => 3.49,
                'image' => 'double-fudge.jpg',
                'is_active' => true,
                'stock_quantity' => 30
            ],
            [
                'name' => 'Oatmeal Raisin Delight',
                'description' => 'Traditional oatmeal cookie packed with plump raisins and warm cinnamon spice. A wholesome treat!',
                'price' => 2.79,
                'image' => 'oatmeal-raisin.jpg',
                'is_active' => true,
                'stock_quantity' => 40
            ],
            [
                'name' => 'Peanut Butter Crunch',
                'description' => 'Creamy peanut butter cookie with a delightful crunch. Made with real peanut butter and love!',
                'price' => 3.19,
                'image' => 'peanut-butter.jpg',
                'is_active' => true,
                'stock_quantity' => 35
            ],
            [
                'name' => 'Sugar Cookie Supreme',
                'description' => 'Light, fluffy sugar cookie with a perfect balance of sweetness. Decorated with colorful sprinkles!',
                'price' => 2.49,
                'image' => 'sugar-cookie.jpg',
                'is_active' => true,
                'stock_quantity' => 60
            ],
            [
                'name' => 'Snickerdoodle Special',
                'description' => 'Soft cinnamon sugar cookie rolled in our special spice blend. A classic favorite that never gets old!',
                'price' => 2.89,
                'image' => 'snickerdoodle.jpg',
                'is_active' => true,
                'stock_quantity' => 45
            ],
            [
                'name' => 'White Chocolate Macadamia',
                'description' => 'Gourmet cookie featuring white chocolate chips and premium macadamia nuts. Pure luxury in every bite!',
                'price' => 3.99,
                'image' => 'white-chocolate-macadamia.jpg',
                'is_active' => true,
                'stock_quantity' => 25
            ],
            [
                'name' => 'Red Velvet Cream',
                'description' => 'Moist red velvet cookie with cream cheese frosting. A sophisticated twist on the classic cake!',
                'price' => 3.79,
                'image' => 'red-velvet.jpg',
                'is_active' => true,
                'stock_quantity' => 20
            ]
        ];

        // BEGINNER EXPLANATION:
        // This loop goes through each product and creates it in the database
        foreach ($products as $productData) {
            Product::create($productData);
        }

        // Display a success message in the terminal
        $this->command->info('🍪 Successfully created ' . count($products) . ' delicious cookie products!');
    }
}
