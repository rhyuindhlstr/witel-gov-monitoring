<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PembayaranPelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pelanggans = \App\Models\Pelanggan::all();

        if ($pelanggans->isEmpty()) {
            $this->command->info('Skipping Pembayaran seeding because Pelanggan data is empty.');
            return;
        }
        
        $totalPayments = 200;
        
        // Distribution: 60% lancar, 25% tertunda (not overdue), 15% overdue
        $lancarCount = (int)($totalPayments * 0.6);
        $tertundaCount = (int)($totalPayments * 0.25);
        $overdueCount = $totalPayments - $lancarCount - $tertundaCount;
        
        $keteranganTemplates = [
            'Pembayaran bulan {month} - Layanan {service}',
            'Tagihan periodik - {service}',
            'Pembayaran kontrak {service}',
            'Biaya bulanan {month} - {service}',
            'Invoice #{invoice} - {service}',
        ];
        
        $services = [
            'Dedicated Internet', 
            'Metro Ethernet', 
            'VPN MPLS', 
            'Cloud Service', 
            'Colocation',
            'Astinet',
            'IP Transit',
            'Wireless'
        ];
        
        $counter = 0;
        
        // Generate LANCAR payments
        for ($i = 0; $i < $lancarCount; $i++) {
            $pelanggan = $pelanggans->random();
            $daysAgo = rand(1, 180);
            $tanggalPembayaran = now()->subDays($daysAgo);
            
            $keterangan = str_replace(
                ['{month}', '{service}', '{invoice}'],
                [$tanggalPembayaran->format('F Y'), $services[array_rand($services)], 'INV' . rand(1000, 9999)],
                $keteranganTemplates[array_rand($keteranganTemplates)]
            );
            
            \App\Models\PembayaranPelanggan::create([
                'pelanggan_id' => $pelanggan->id,
                'tanggal_pembayaran' => $tanggalPembayaran,
                'tanggal_jatuh_tempo' => $tanggalPembayaran->copy()->setDay(20),
                'nominal' => rand(5, 100) * 1000000, // Rp 5 juta - 100 juta
                'status_pembayaran' => 'lancar',
                'keterangan' => $keterangan . ' - Lunas'
            ]);
            $counter++;
        }
        
        // Generate TERTUNDA (not overdue yet) payments
        for ($i = 0; $i < $tertundaCount; $i++) {
            $pelanggan = $pelanggans->random();
            
            // Payment date in the past, but due date is in the future
            $tanggalPembayaran = now()->subDays(rand(10, 60));
            $tanggalJatuhTempo = now()->addDays(rand(1, 30))->setDay(20);
            
            $keterangan = str_replace(
                ['{month}', '{service}', '{invoice}'],
                [$tanggalPembayaran->format('F Y'), $services[array_rand($services)], 'INV' . rand(1000, 9999)],
                $keteranganTemplates[array_rand($keteranganTemplates)]
            );
            
            \App\Models\PembayaranPelanggan::create([
                'pelanggan_id' => $pelanggan->id,
                'tanggal_pembayaran' => $tanggalPembayaran,
                'tanggal_jatuh_tempo' => $tanggalJatuhTempo,
                'nominal' => rand(10, 150) * 1000000, // Rp 10 juta - 150 juta
                'status_pembayaran' => 'tertunda',
                'keterangan' => $keterangan . ' - Menunggu pembayaran'
            ]);
            $counter++;
        }
        
        // Generate OVERDUE payments
        for ($i = 0; $i < $overdueCount; $i++) {
            $pelanggan = $pelanggans->random();
            
            // Payment date and due date both in the past
            $daysOverdue = rand(5, 90);
            $tanggalJatuhTempo = now()->subDays($daysOverdue)->setDay(20);
            $tanggalPembayaran = $tanggalJatuhTempo->copy()->subDays(rand(30, 60));
            
            $keterangan = str_replace(
                ['{month}', '{service}', '{invoice}'],
                [$tanggalPembayaran->format('F Y'), $services[array_rand($services)], 'INV' . rand(1000, 9999)],
                $keteranganTemplates[array_rand($keteranganTemplates)]
            );
            
            \App\Models\PembayaranPelanggan::create([
                'pelanggan_id' => $pelanggan->id,
                'tanggal_pembayaran' => $tanggalPembayaran,
                'tanggal_jatuh_tempo' => $tanggalJatuhTempo,
                'nominal' => rand(15, 200) * 1000000, // Rp 15 juta - 200 juta
                'status_pembayaran' => 'tertunda',
                'keterangan' => $keterangan . ' - OVERDUE ' . $daysOverdue . ' hari'
            ]);
            $counter++;
        }
        
        $this->command->info("Created {$counter} pembayaran records:");
        $this->command->info("  - Lancar: {$lancarCount}");
        $this->command->info("  - Tertunda (belum jatuh tempo): {$tertundaCount}");
        $this->command->info("  - Overdue: {$overdueCount}");
    }
}
