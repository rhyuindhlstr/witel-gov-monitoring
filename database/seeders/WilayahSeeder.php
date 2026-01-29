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
        // Data kosong sesuai branch GS-Intan
        $wilayahs = [
            [
                'code' => 'WITEL-LPG',
                'nama_wilayah' => 'Witel Lampung',
                'keterangan' => 'Wilayah Lampung'
            ],
            [
                'code' => 'WITEL-BGL',
                'nama_wilayah' => 'Witel Bengkulu',
                'keterangan' => 'Wilayah Bengkulu'
            ],
           [
                'code' => 'WITEL-METRO',
                'nama_wilayah' => 'Witel Metro',
                'keterangan' => 'Wilayah Metro'
            ],
            [
                'code' => 'WITEL-KLI',
                'nama_wilayah' => 'Witel Kalianda',
                'keterangan' => 'Wilayah Kalianda'
            ],
            [
                'code' => 'WITEL-KTB',
                'nama_wilayah' => 'Witel Kotabumi',
                'keterangan' => 'Wilayah Kotabumi'
            ],
             [
                'code' => 'WITEL-LWA',
                'nama_wilayah' => 'Witel Liwa',
                'keterangan' => 'Wilayah Liwa'
            ],
             [
                'code' => 'WITEL-PSW',
                'nama_wilayah' => 'Witel Pringsewu',
                'keterangan' => 'Wilayah Pringsewu'
            ],
        ];

        foreach ($wilayahs as $wilayah) {
            \App\Models\Wilayah::create($wilayah);
        }
    }
}
