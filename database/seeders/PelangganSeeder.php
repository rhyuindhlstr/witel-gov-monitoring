<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wilayahs = \App\Models\Wilayah::all();

        if ($wilayahs->isEmpty()) {
            $this->command->info('Skipping Pelanggan seeding because Wilayah data is empty.');
            return;
        }
        
        $institutions = [
            // Lampung
            ['nama' => 'Dinas Pendidikan Lampung', 'pic' => 'Dr. Ahmad Hidayat, M.Pd', 'telepon' => '0721-123001'],
            ['nama' => 'RSUD Dr. H. Abdul Moeloek', 'pic' => 'dr. Siti Nurhaliza, Sp.PD', 'telepon' => '0721-123002'],
            ['nama' => 'Pemda Lampung Selatan', 'pic' => 'Ir. Bambang Santoso', 'telepon' => '0721-123003'],
            ['nama' => 'Polda Lampung', 'pic' => 'AKBP Hendra Wijaya', 'telepon' => '0721-123004'],
            ['nama' => 'Dinas Kesehatan Bandar Lampung', 'pic' => 'Dr. Rina Marlina, M.Kes', 'telepon' => '0721-123005'],
            ['nama' => 'BPKAD Lampung', 'pic' => 'Drs. Joko Susilo, M.Si', 'telepon' => '0721-123006'],
            ['nama' => 'Dinas Perhubungan Lampung', 'pic' => 'Ir. Sutrisno', 'telepon' => '0721-123007'],
            ['nama' => 'Kantor Wali Kota Bandar Lampung', 'pic' => 'Andi Setiawan, SH', 'telepon' => '0721-123008'],
            ['nama' => 'DPRD Lampung', 'pic' => 'H. Muhammad Yusuf', 'telepon' => '0721-123009'],
            ['nama' => 'Universitas Lampung', 'pic' => 'Prof. Dr. Ir. Suharno, M.Sc', 'telepon' => '0721-123010'],
            ['nama' => 'SMKN 1 Bandar Lampung', 'pic' => 'Dra. Sri Wahyuni, M.Pd', 'telepon' => '0721-123011'],
            ['nama' => 'Dinas Sosial Lampung', 'pic' => 'Hj. Ratna Dewi, S.Sos', 'telepon' => '0721-123012'],
            ['nama' => 'Kantor Imigrasi Lampung', 'pic' => 'Agus Prasetyo, SH', 'telepon' => '0721-123013'],
            ['nama' => 'BNN Provinsi Lampung', 'pic' => 'Kombes Pol. Bambang', 'telepon' => '0721-123014'],
            ['nama' => 'Dinas Pekerjaan Umum Lampung', 'pic' => 'Ir. Hadi Purnomo, MT', 'telepon' => '0721-123015'],
            ['nama' => 'Kejaksaan Tinggi Lampung', 'pic' => 'Andi Kurniawan, SH, MH', 'telepon' => '0721-123016'],
            ['nama' => 'Pengadilan Tinggi Lampung', 'pic' => 'Dr. Suryadi, SH, MH', 'telepon' => '0721-123017'],
            ['nama' => 'Kantor Kemenag Lampung', 'pic' => 'Drs. H. Abdul Rahman, M.Ag', 'telepon' => '0721-123018'],
            ['nama' => 'BPJS Kesehatan Cabang Lampung', 'pic' => 'Desi Ratnasari, SE', 'telepon' => '0721-123019'],
            ['nama' => 'Perum Bulog Lampung', 'pic' => 'Ir. Bambang Sulistyo', 'telepon' => '0721-123020'],
            ['nama' => 'Dinas Pariwisata Lampung', 'pic' => 'Drs. Eko Prasetyo', 'telepon' => '0721-123021'],
            ['nama' => 'RSUD Kota Metro', 'pic' => 'dr. Fitri Handayani, Sp.A', 'telepon' => '0721-123022'],
            ['nama' => 'Pemda Lampung Utara', 'pic' => 'Ir. Agus Mulyono', 'telepon' => '0721-123023'],
            ['nama' => 'Dinas Pertanian Lampung', 'pic' => 'Ir. Suharto, MP', 'telepon' => '0721-123024'],
            ['nama' => 'Satpol PP Bandar Lampung', 'pic' => 'Drs. Herman Wijaya', 'telepon' => '0721-123025'],
            
            // Bengkulu
            ['nama' => 'Dinas Pendidikan Bengkulu', 'pic' => 'Dr. Nurhayati, M.Pd', 'telepon' => '0736-123001'],
            ['nama' => 'RSUD M. Yunus Bengkulu', 'pic' => 'dr. Rudi Hartono, Sp.B', 'telepon' => '0736-123002'],
            ['nama' => 'Pemda Bengkulu Selatan', 'pic' => 'Ir. Hasan Basri', 'telepon' => '0736-123003'],
            ['nama' => 'Polda Bengkulu', 'pic' => 'AKBP Dedi Kusuma', 'telepon' => '0736-123004'],
            ['nama' => 'Dinas Kesehatan Bengkulu', 'pic' => 'Dr. Lina Marliana, M.Kes', 'telepon' => '0736-123005'],
            ['nama' => 'Kantor Wali Kota Bengkulu', 'pic' => 'H. Rahman Effendi, SH', 'telepon' => '0736-123006'],
            ['nama' => 'DPRD Bengkulu', 'pic' => 'Drs. Ali Murtadho', 'telepon' => '0736-123007'],
            ['nama' => 'Universitas Bengkulu', 'pic' => 'Prof. Dr. Ridwan Nurazi', 'telepon' => '0736-123008'],
            ['nama' => 'SMAN 1 Bengkulu', 'pic' => 'Dra. Yuliana, M.Pd', 'telepon' => '0736-123009'],
            ['nama' => 'Dinas Perhubungan Bengkulu', 'pic' => 'Ir. Hermanto', 'telepon' => '0736-123010'],
            ['nama' => 'Kantor Imigrasi Bengkulu', 'pic' => 'Rudi Prabowo, SH', 'telepon' => '0736-123011'],
            ['nama' => 'Dinas PU Bengkulu', 'pic' => 'Ir. Slamet Riyadi, MT', 'telepon' => '0736-123012'],
            ['nama' => 'Kejaksaan Negeri Bengkulu', 'pic' => 'Yudi Setiawan, SH, MH', 'telepon' => '0736-123013'],
            ['nama' => 'Pengadilan Negeri Bengkulu', 'pic' => 'Dr. Haryanto, SH, MH', 'telepon' => '0736-123014'],
            ['nama' => 'Kantor Kemenag Bengkulu', 'pic' => 'Drs. H. Usman, M.Ag', 'telepon' => '0736-123015'],
            ['nama' => 'BPJS Kesehatan Cabang Bengkulu', 'pic' => 'Wati Susanti, SE', 'telepon' => '0736-123016'],
            ['nama' => 'Dinas Sosial Bengkulu', 'pic' => 'Hj. Maya Sari, S.Sos', 'telepon' => '0736-123017'],
            ['nama' => 'Pemda Bengkulu Utara', 'pic' => 'Ir. Fikri Hakim', 'telepon' => '0736-123018'],
            ['nama' => 'Dinas Pertanian Bengkulu', 'pic' => 'Ir. Yusuf Ibrahim, MP', 'telepon' => '0736-123019'],
            ['nama' => 'Satpol PP Bengkulu', 'pic' => 'Drs. Eko Wahyudi', 'telepon' => '0736-123020'],
            ['nama' => 'RSUD Bengkulu Selatan', 'pic' => 'dr. Santi Lestari, Sp.PD', 'telepon' => '0736-123021'],
            ['nama' => 'Dinas Pariwisata Bengkulu', 'pic' => 'Drs. Faisal Ahmad', 'telepon' => '0736-123022'],
            ['nama' => 'BNN Bengkulu', 'pic' => 'Kompol Taufik Hidayat', 'telepon' => '0736-123023'],
            ['nama' => 'Perum Bulog Bengkulu', 'pic' => 'Ir. Yanto Sugiarto', 'telepon' => '0736-123024'],
            ['nama' => 'BPKAD Bengkulu', 'pic' => 'Drs. Heru Susanto, M.Si', 'telepon' => '0736-123025'],
        ];

        foreach ($institutions as $index => $inst) {
            \App\Models\Pelanggan::create([
                'nama_pelanggan' => $inst['nama'],
                'nama_pic' => $inst['pic'],
                'alamat' => 'Jl. ' . ['Jenderal Sudirman', 'Ahmad Yani', 'Teuku Umar', 'Kartini', 'Diponegoro'][array_rand([0,1,2,3,4])] . ' No. ' . rand(1, 200),
                'no_telepon' => $inst['telepon'],
                'email' => strtolower(str_replace([' ', '.', ','], ['', '', ''], explode(',', $inst['pic'])[0])) . '@example.com',
                'wilayah_id' => $wilayahs->random()->id,
                'keterangan' => 'Customer aktif sejak ' . rand(2020, 2024) . '. ' . ['Prioritas tinggi', 'Customer strategis', 'Kontrak rutin tahunan', 'Partner jangka panjang'][array_rand([0,1,2,3])]
            ]);
        }

        $this->command->info('Created ' . count($institutions) . ' pelanggan records');
    }
}
