<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class MarketingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Marketing User',
            'email' => 'marketing@telkom.com',
            'password' => Hash::make('password'),
            'role' => 'marketing',
            'phone' => '081234567891',
        ]);
    }
}
