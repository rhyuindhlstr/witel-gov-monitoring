<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            UserSeeder::class,
            // SSGS Seeders
            WilayahSeeder::class,
            PelangganSeeder::class,
            KunjunganPelangganSeeder::class,
            PembayaranPelangganSeeder::class,
            // GS Seeders
            WilayahGSSeeder::class,
            PeluangProyekGSSeeder::class,
            AktivitasMarketingSeeder::class,
        ]);
    }
}
