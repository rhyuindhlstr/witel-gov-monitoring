<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin user
        \App\Models\User::create([
            'name' => 'Admin System',
            'email' => 'admin@telkom.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        // Create Marketing SSGS users
        $marketingUsers = [
            ['name' => 'Andi Setiawan', 'email' => 'andi.setiawan@telkom.com'],
            ['name' => 'Siti Rahma', 'email' => 'siti.rahma@telkom.com'],
            ['name' => 'Budi Santoso', 'email' => 'budi.santoso@telkom.com'],
        ];

        foreach ($marketingUsers as $user) {
            \App\Models\User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]);
        }

        $this->command->info('Created ' . (count($marketingUsers) + 1) . ' user records');
    }
}
