<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@bunnybakes.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now()
        ]);


        // Display success message
        $this->command->info(' Successfully created admin and customer users!');
        $this->command->info(' Admin: admin@bunnybakes.com / password');
        $this->command->info(' Customer: customer@example.com / password');
    }
}
