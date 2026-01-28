<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KunjunganPelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Business Rule: Kunjungan dilakukan 1x per bulan untuk pelanggan yang belum bayar tagihan bulan tersebut
        
        $users = \App\Models\User::where('email', '!=', 'admin@telkom.com')->get();
        
        // Get all pembayaran tertunda (unpaid bills)
        $pembayaranTertunda = \App\Models\PembayaranPelanggan::where('status_pembayaran', 'tertunda')
                                ->orderBy('tanggal_jatuh_tempo')
                                ->get();
        
        // Hasil kunjungan: komitmen bayar (60%), pemutusan wifi (20%), minta perpanjangan (20%)
        $hasilKomitmenBayar = [
            'Customer berkomitmen melakukan pembayaran paling lambat tanggal {date}. Total tagihan: Rp {amount} juta. Akan di-follow up kembali jika belum ada pembayaran.',
            'Customer sudah memproses pembayaran via transfer banking. Diminta mengirimkan bukti transfer maksimal {days} hari. Total: Rp {amount} juta.',
            'Customer menyetujui pembayaran bertahap: 50% ({partial} juta) tanggal {date}, sisanya tanggal {date2}. Total tagihan: Rp {amount} juta.',
            'Customer akan melakukan pembayaran tunai ke kantor Telkom tanggal {date}. Total: Rp {amount} juta. Tim finance sudah diberitahu.',
            'Pembayaran sudah dijadwalkan melalui auto-debit tanggal {date}. Customer memastikan saldo mencukupi. Total: Rp {amount} juta.',
        ];
        
        $hasilPemutusan = [
            'Customer belum bisa bayar. Tim teknis dijadwalkan melakukan isolir layanan tanggal {date}. Customer diberikan waktu {days} hari terakhir untuk pembayaran.',
            'Pemutusan sementara (isolir) sudah dilakukan hari ini. Layanan akan diaktifkan kembali setelah pembayaran Rp {amount} juta diterima.',
            'Customer request jangan diputus, berjanji bayar maksimal {days} hari. Jika tidak, akan langsung diputus tanggal {date}.',
            'Sudah diberikan SP (Surat Peringatan) terakhir. Jika pembayaran Rp {amount} juta tidak masuk tanggal {date}, layanan akan diputus permanen.',
        ];
        
        $hasilPerpanjangan = [
            'Customer request perpanjangan tempo pembayaran s/d tanggal {date}. Alasan: {reason}. Menunggu approval management.',
            'Perpanjangan tempo disetujui sampai tanggal {date}. Customer berkomitmen tidak akan terlambat lagi. Total: Rp {amount} juta.',
            'Customer minta cicil pembayaran 3x. Menunggu persetujuan dari credit control. Proposal cicilan: {date}, {date2}, dan bulan depan.',
            'Request keringanan pembayaran diajukan. Customer mengalami {reason}. Akan dikonfirmasi ke bagian collection dalam {days} hari.',
        ];
        
        $reasons = [
            'kendala cash flow perusahaan',
            'menunggu pencairan anggaran',
            'proses administrasi yang tertunda',
            'perpindahan PIC keuangan',
            'revisi anggaran internal'
        ];
        
        $visitCounter = 0;
        $processedPelangganMonth = []; // Track pelanggan-month to ensure 1 visit per month
        
        foreach ($pembayaranTertunda as $pembayaran) {
            $pelanggan = $pembayaran->pelanggan;
            $tanggalJatuhTempo = $pembayaran->tanggal_jatuh_tempo;
            
            if (!$tanggalJatuhTempo) continue;
            
            // Create unique key: pelanggan_id + year-month
            $monthKey = $pelanggan->id . '_' . $tanggalJatuhTempo->format('Y-m');
            
            // Skip if already visited this pelanggan in this month
            if (in_array($monthKey, $processedPelangganMonth)) {
                continue;
            }
            
            // Visit happens after due date (after 20th)
            // Random: 3-15 days after due date
            $daysAfterDue = rand(3, 15);
            $tanggalKunjungan = $tanggalJatuhTempo->copy()->addDays($daysAfterDue);
            
            // Don't create future visits
            if ($tanggalKunjungan->isFuture()) {
                continue;
            }
            
            $user = $users->random();
            
            // Randomly select outcome type: 60% komitmen bayar, 20% pemutusan, 20% perpanjangan
            $rand = rand(1, 100);
            if ($rand <= 60) {
                $hasilTemplate = $hasilKomitmenBayar[array_rand($hasilKomitmenBayar)];
            } elseif ($rand <= 80) {
                $hasilTemplate = $hasilPemutusan[array_rand($hasilPemutusan)];
            } else {
                $hasilTemplate = $hasilPerpanjangan[array_rand($hasilPerpanjangan)];
            }
            
            $nextDate = $tanggalKunjungan->copy()->addDays(rand(3, 10));
            $nextDate2 = $nextDate->copy()->addDays(rand(7, 14));
            
            $nominal = $pembayaran->nominal / 1000000; // Convert to millions
            $partialAmount = round($nominal * 0.5); // 50% for partial payment
            
            $hasil = str_replace(
                ['{date}', '{date2}', '{days}', '{amount}', '{partial}', '{reason}'],
                [
                    $nextDate->format('d M Y'),
                    $nextDate2->format('d M Y'),
                    rand(3, 7),
                    number_format($nominal, 0, ',', '.'),
                    number_format($partialAmount, 0, ',', '.'),
                    $reasons[array_rand($reasons)]
                ],
                $hasilTemplate
            );
            
            // Create kunjungan
            \App\Models\KunjunganPelanggan::create([
                'pelanggan_id' => $pelanggan->id,
                'user_id' => $user->id,
                'tanggal_kunjungan' => $tanggalKunjungan,
                'tujuan' => 'Follow-up pembayaran tagihan bulan ' . $tanggalJatuhTempo->format('F Y'),
                'hasil_kunjungan' => $hasil
            ]);
            
            // Mark this pelanggan-month as processed
            $processedPelangganMonth[] = $monthKey;
            $visitCounter++;
        }
        
        $this->command->info("Created {$visitCounter} kunjungan records (1 per month for unpaid bills)");
        $this->command->info("Business rule applied: Kunjungan hanya untuk pelanggan dengan tagihan tertunda");
    }
}
