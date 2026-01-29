<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PeluangProyekGS;
use App\Models\WilayahGS;
use Faker\Factory as Faker;

class PeluangProyekGSSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        $wilayahs = WilayahGS::pluck('id')->toArray();
        $statuses = ['PROSPECT', 'KEGIATAN_VALID', 'WIN', 'LOSE', 'CANCEL'];
        $services = ['Connectivity', 'IT Services', 'CPE', 'Cloud', 'Managed Service'];

        if (empty($wilayahs)) {
            $this->command->error('WilayahGS table is empty. Please run WilayahGSSeeder first.');
            return;
        }

        foreach (range(1, 50) as $index) {
            $status = $faker->randomElement($statuses);
            $estimasi = $faker->numberBetween(10, 500) * 1000000; // 10jt - 500jt
            $realisasi = ($status == 'WIN') ? $estimasi : 0;

            PeluangProyekGS::create([
                'wilayah_id' => $faker->randomElement($wilayahs),
                'id_am' => 'AM-' . $faker->unique()->numerify('####'),
                'nama_am' => $faker->name,
                'nama_gc' => $faker->company,
                'satker' => 'Dinas ' . $faker->randomElement(['Pendidikan', 'Kesehatan', 'PU', 'Kominfo', 'Perhubungan']) . ' ' . $faker->city,
                'judul_proyek' => 'Pengadaan ' . $faker->randomElement(['Internet', 'Server', 'CCTV', 'Aplikasi', 'Jaringan LAN']) . ' Tahun ' . date('Y'),
                'jenis_layanan' => $faker->randomElement($services),
                'jenis_proyek' => $faker->randomElement(['New Sales', 'Recurring']),
                'nilai_estimasi' => $estimasi,
                'nilai_realisasi' => $realisasi,
                'nilai_scaling' => $estimasi * 1.5,
                'status_mytens' => $faker->randomElement(['F0', 'F1', 'F2', 'F3', 'F4', 'F5']),
                'status_proyek' => $status,
                'mekanisme_pengadaan' => $faker->randomElement(['Lelang', 'Penunjukan Langsung', 'E-Catalog']),
                'start_pelaksanaan' => $faker->date(),
                'end_pelaksanaan' => $faker->date(),
                'keterangan' => $faker->sentence,
                'tanggal_input' => $faker->dateTimeThisYear()->format('Y-m-d'),
            ]);
        }
    }
}
