<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cookie;

class CookieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * This will create sample cookie products for the store.
     */
    public function run(): void
    {
        // Array of delicious cookies to add to our store
        $cookies = [
            [
                'name' => 'Classic Chocolate Chip',
                'description' => 'Our signature cookie made with premium chocolate chips and a hint of vanilla. Soft, chewy, and absolutely irresistible!',
                'price' => 2.99,
                'image' => 'chocolate-chip.jpg' // You can add actual images later
            ],
            [
                'name' => 'Double Fudge Brownie',
                'description' => 'Rich, decadent brownie cookie loaded with chocolate chunks. Perfect for serious chocolate lovers!',
                'price' => 3.49,
                'image' => 'double-fudge.jpg'
            ],
            [
                'name' => 'Oatmeal Raisin Delight',
                'description' => 'Traditional oatmeal cookie packed with plump raisins and warm cinnamon spice. A wholesome treat!',
                'price' => 2.79,
                'image' => 'oatmeal-raisin.jpg'
            ],
            [
                'name' => 'Peanut Butter Crunch',
                'description' => 'Creamy peanut butter cookie with a delightful crunch. Made with real peanut butter and love!',
                'price' => 3.19,
                'image' => 'peanut-butter.jpg'
            ],
            [
                'name' => 'Sugar Cookie Supreme',
                'description' => 'Light, fluffy sugar cookie with a perfect balance of sweetness. Decorated with colorful sprinkles!',
                'price' => 2.49,
                'image' => 'sugar-cookie.jpg'
            ],
            [
                'name' => 'Snickerdoodle Special',
                'description' => 'Soft cinnamon sugar cookie rolled in our special spice blend. A classic favorite that never gets old!',
                'price' => 2.89,
                'image' => 'snickerdoodle.jpg'
            ],
            [
                'name' => 'White Chocolate Macadamia',
                'description' => 'Gourmet cookie featuring white chocolate chips and premium macadamia nuts. Pure luxury in every bite!',
                'price' => 3.99,
                'image' => 'white-chocolate-macadamia.jpg'
            ],
            [
                'name' => 'Red Velvet Cream',
                'description' => 'Moist red velvet cookie with cream cheese frosting. A sophisticated twist on the classic cake!',
                'price' => 3.79,
                'image' => 'red-velvet.jpg'
            ]
        ];

        // Loop through each cookie and create it in the database
        foreach ($cookies as $cookieData) {
            Cookie::create($cookieData);
        }

        // Display a message when seeding is complete
        $this->command->info('🍪 Successfully created ' . count($cookies) . ' delicious cookies!');
    }
}
