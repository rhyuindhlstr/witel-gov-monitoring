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
        // Marketing SSGS users
        $marketingUsers = [
            ['name' => 'Andi Setiawan', 'email' => 'andi.setiawan@telkom.com'],
            ['name' => 'Siti Rahma', 'email' => 'siti.rahma@telkom.com'],
            ['name' => 'Budi Santoso', 'email' => 'budi.santoso@telkom.com'],
        ];

        foreach ($marketingUsers as $user) {
            \App\Models\User::firstOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'password' => bcrypt('password'),
                    'email_verified_at' => now(),
                    'role' => 'ssgs',
                ]
            );
        }

        // Create GS User
        \App\Models\User::firstOrCreate(
            ['email' => 'eko.prasetyo@telkom.com'],
            [
                'name' => 'Eko Prasetyo',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
                'role' => 'gs',
            ]
        );

        $this->command->info('Created ' . (count($marketingUsers) + 1) . ' user records');
    }
}
