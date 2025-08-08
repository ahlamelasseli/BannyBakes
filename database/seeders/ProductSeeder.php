<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

// class ProductSeeder extends Seeder
// {
    /**
     * Run the database seeds.
     * BEGINNER EXPLANATION:
     * This seeder creates sample cookie products in the database.
     * Run this with: php artisan db:seed --class=ProductSeeder
    //  */
    // public function run(): void
    // {
    //     // BEGINNER EXPLANATION:
        // This array contains all the cookie data we want to add to our store
        // $products = [
        //     [
        //         'name' => 'Classic Chocolate Chip',
        //         'description' => 'Our signature cookie made with premium chocolate chips and a hint of vanilla. Soft, chewy, and absolutely irresistible!',
        //         'price' => 2.99,
        //         'image' => 'https://i.pinimg.com/1200x/b3/ac/77/b3ac7733c4c0f81d13b5024bebae3408.jpg', // You can add actual images to public/images/
        //         'is_active' => true,
        //         'stock_quantity' => 50
        //     ],
        //     [
        //         'name' => 'Double Fudge Brownie',
        //         'description' => 'Rich, decadent brownie cookie loaded with chocolate chunks. Perfect for serious chocolate lovers!',
        //         'price' => 3.49,
        //         'image' => 'https://i.pinimg.com/1200x/2a/28/b3/2a28b3a218b96bad5ab9550d803ec2b1.jpg',
        //         'is_active' => true,
        //         'stock_quantity' => 30
        //     ],
        //     [
        //         'name' => 'Oatmeal Raisin Delight',
        //         'description' => 'Traditional oatmeal cookie packed with plump raisins and warm cinnamon spice. A wholesome treat!',
        //         'price' => 2.79,
        //         'image' => 'https://i.pinimg.com/736x/a1/d9/eb/a1d9ebbf10695fb98e1fe0b01b82c5e2.jpg',
        //         'is_active' => true,
        //         'stock_quantity' => 40
        //     ],
        //     [
        //         'name' => 'Peanut Butter Crunch',
        //         'description' => 'Creamy peanut butter cookie with a delightful crunch. Made with real peanut butter and love!',
        //         'price' => 3.19,
        //         'image' => 'https://i.pinimg.com/1200x/de/be/0f/debe0f80a42f06fc5bd35cd3556604e4.jpg',
        //         'is_active' => true,
        //         'stock_quantity' => 35
        //     ],
        //     [
        //         'name' => 'Snickerdoodle Special',
        //         'description' => 'Soft cinnamon sugar cookie rolled in our special spice blend. A classic favorite that never gets old!',
        //         'price' => 2.89,
        //         'image' => 'https://i.pinimg.com/1200x/54/4e/cf/544ecf15f2bbed357366b195e0e35e26.jpg',
        //         'is_active' => true,
        //         'stock_quantity' => 45
        //     ],
        //     [
        //         'name' => 'White Chocolate Macadamia',
        //         'description' => 'Gourmet cookie featuring white chocolate chips and premium macadamia nuts. Pure luxury in every bite!',
        //         'price' => 3.99,
        //         'image' => 'https://i.pinimg.com/1200x/0b/d6/2a/0bd62ae7c4a213a17980f29dc1be7654.jpg',
        //         'is_active' => true,
        //         'stock_quantity' => 25
        //     ],
        //     [
        //         'name' => 'Red Velvet Cream',
        //         'description' => 'Moist red velvet cookie with cream cheese frosting. A sophisticated twist on the classic cake!',
        //         'price' => 3.79,
        //         'image' => 'https://i.pinimg.com/1200x/80/6a/ac/806aacc0d5c4b2ae2a0ca335922e85a8.jpg',
        //         'is_active' => true,
        //         'stock_quantity' => 20
        //     ]
        // ];

        // BEGINNER EXPLANATION:
//         // This loop goes through each product and creates it in the database
//         foreach ($products as $productData) {
//             Product::create($productData);
//         }

//         // Display a success message in the terminal
//         $this->command->info(' Successfully created ' . count($products) . ' delicious cookie products!');
//     }
// }
