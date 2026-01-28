<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WilayahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wilayahs = [
            ['nama_wilayah' => 'Bandar Lampung', 'keterangan' => 'Kota Bandar Lampung'],
            ['nama_wilayah' => 'Lampung Selatan', 'keterangan' => 'Kabupaten Lampung Selatan'],
            ['nama_wilayah' => 'Lampung Utara', 'keterangan' => 'Kabupaten Lampung Utara'],
            ['nama_wilayah' => 'Lampung Tengah', 'keterangan' => 'Kabupaten Lampung Tengah'],
            ['nama_wilayah' => 'Lampung Timur', 'keterangan' => 'Kabupaten Lampung Timur'],
            ['nama_wilayah' => 'Pringsewu', 'keterangan' => 'Kabupaten Pringsewu'],
            ['nama_wilayah' => 'Metro', 'keterangan' => 'Kota Metro'],
            ['nama_wilayah' => 'Bengkulu', 'keterangan' => 'Kota Bengkulu'],
            ['nama_wilayah' => 'Bengkulu Selatan', 'keterangan' => 'Kabupaten Bengkulu Selatan'],
            ['nama_wilayah' => 'Bengkulu Utara', 'keterangan' => 'Kabupaten Bengkulu Utara'],
        ];

        foreach ($wilayahs as $wilayah) {
            \App\Models\Wilayah::create($wilayah);
        }
    }
}
