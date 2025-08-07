<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;

class TestOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * BEGINNER EXPLANATION:
     * This creates test orders with different dates to demonstrate the follow-up calendar.
     * Orders are created for various dates so you can see the calendar functionality.
     */
    public function run(): void
    {
        // Get users and products for creating orders
        $customer = User::where('role', 'customer')->first();
        $products = Product::take(3)->get();

        if (!$customer || $products->count() === 0) {
            $this->command->error('Please run UserSeeder and ProductSeeder first!');
            return;
        }

        // Create test orders for different dates
        $testDates = [
            Carbon::now()->subDays(5), // 5 days ago (follow-up was 3 days ago - overdue)
            Carbon::now()->subDays(3), // 3 days ago (follow-up was yesterday - overdue)
            Carbon::now()->subDays(2), // 2 days ago (follow-up is today)
            Carbon::now()->subDays(1), // 1 day ago (follow-up is tomorrow)
            Carbon::now(),             // Today (follow-up in 2 days)
        ];

        foreach ($testDates as $index => $orderDate) {
            // Create order
            $order = Order::create([
                'user_id' => $customer->id,
                'customer_name' => $customer->name,
                'customer_email' => $customer->email,
                'shipping_address' => '123 Test Street, Test City, TC 12345',
                'total_amount' => rand(15, 50),
                'status' => 'Order Placed',
                'estimated_delivery_date' => $orderDate->copy()->addDays(3),
                'created_at' => $orderDate,
                'updated_at' => $orderDate,
            ]);

            // Add order items
            $product = $products->random();
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'product_price' => $product->price,
                'quantity' => rand(1, 3),
                'subtotal' => $product->price * rand(1, 3),
                'created_at' => $orderDate,
                'updated_at' => $orderDate,
            ]);
        }

        // Create additional orders for next week to show future follow-ups
        for ($i = 1; $i <= 7; $i++) {
            $futureDate = Carbon::now()->addDays($i);

            $order = Order::create([
                'user_id' => $customer->id,
                'customer_name' => "Customer " . ($i + 5),
                'customer_email' => "customer{$i}@example.com",
                'shipping_address' => "Address {$i}, Future City, FC 1234{$i}",
                'total_amount' => rand(20, 60),
                'status' => 'Order Placed',
                'estimated_delivery_date' => $futureDate->copy()->addDays(3),
                'created_at' => $futureDate->subDays(2), // Order was placed 2 days before future date
                'updated_at' => $futureDate->subDays(2),
            ]);

            $product = $products->random();
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'product_price' => $product->price,
                'quantity' => rand(1, 2),
                'subtotal' => $product->price * rand(1, 2),
                'created_at' => $futureDate->subDays(2),
                'updated_at' => $futureDate->subDays(2),
            ]);
        }

        $this->command->info('📅 Successfully created test orders for calendar demonstration!');
        $this->command->info('🔔 Check the admin calendar to see follow-up dates.');
    }
}
