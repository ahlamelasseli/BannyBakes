<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * BEGINNER EXPLANATION:
     * This is the main seeder that runs when you execute: php artisan db:seed
     * It calls other seeders in the correct order.
     */
    public function run(): void
    {
        // BEGINNER EXPLANATION:
        // Run seeders in order - users first, then products
        $this->call([
            UserSeeder::class,      // Creates admin and customer users
            ProductSeeder::class,   // Creates sample cookie products
        ]);

        $this->command->info('🎉 Database seeding completed successfully!');
        $this->command->info('🚀 You can now login with:');
        $this->command->info('   Admin: admin@bunnybakes.com / password');
        $this->command->info('   Customer: customer@example.com / password');
    }
}
