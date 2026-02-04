<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WilayahGS;

class WilayahGSSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $wilayahs = [
            'Witel Lampung',
            'Witel Bengkulu',
            'Witel Metro',
            'Witel Pringsewu',
            'Witel Kalianda',
            'Witel Kotabumi',
            'Witel Liwa',
        ];

        foreach ($wilayahs as $nama) {
            WilayahGS::create([
                'nama_wilayah' => $nama,
                'keterangan' => 'Wilayah Operasional ' . $nama,
            ]);
        }
    }
}
