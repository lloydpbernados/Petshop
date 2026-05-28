<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create your specific Admin user
        User::factory()->create([
            'name'  => 'PawHaven Admin',
            'email' => 'admin@pawhaven.ph',
            'role'  => 'admin', 
        ]);

        // 2. Create your specific Customer user
        User::factory()->create([
            'name'  => 'Juan Dela Cruz',
            'email' => 'customer@gmail.com',
            'role'  => 'customer',
        ]);

     
    }
}