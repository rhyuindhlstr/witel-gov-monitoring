<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AktivitasMarketing;
use App\Models\PeluangProyekGS;
use Faker\Factory as Faker;

class AktivitasMarketingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        $proyekIds = PeluangProyekGS::pluck('id')->toArray();
        $aktivitasTypes = ['Meeting', 'Visit', 'Call', 'Presentasi', 'Negosiasi', 'Survey'];

        if (empty($proyekIds)) {
            $this->command->error('PeluangProyekGS table is empty. Please run PeluangProyekGSSeeder first.');
            return;
        }

        foreach (range(1, 100) as $index) {
            AktivitasMarketing::create([
                'peluang_proyek_gs_id' => $faker->randomElement($proyekIds),
                'tanggal' => $faker->dateTimeThisMonth()->format('Y-m-d'),
                'jenis_aktivitas' => $faker->randomElement($aktivitasTypes),
                'hasil' => $faker->sentence,
                'keterangan' => $faker->sentence,
            ]);
        }
    }
}
