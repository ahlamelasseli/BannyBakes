<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * BEGINNER EXPLANATION:
     * This seeder creates an admin user and a sample customer user.
     * Run this with: php artisan db:seed --class=UserSeeder
     */
    public function run(): void
    {
        // BEGINNER EXPLANATION:
        // Create an admin user for testing the admin dashboard
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@bunnybakes.com',
            'password' => Hash::make('password'), // Hash::make encrypts the password
            'role' => 'admin',
            'email_verified_at' => now() // Mark email as verified
        ]);

        // BEGINNER EXPLANATION:
        // Create a sample customer user for testing
        User::create([
            'name' => 'John Customer',
            'email' => 'customer@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'email_verified_at' => now() // Mark email as verified
        ]);

        // Display success message
        $this->command->info('👤 Successfully created admin and customer users!');
        $this->command->info('📧 Admin: admin@bunnybakes.com / password');
        $this->command->info('📧 Customer: customer@example.com / password');
    }
}
