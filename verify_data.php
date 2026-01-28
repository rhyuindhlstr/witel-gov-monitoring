<?php

echo "=== Database Summary ===\n\n";

echo "Users: " . App\Models\User::count() . "\n";
echo "Wilayah: " . App\Models\Wilayah::count() . "\n";
echo "Pelanggan: " . App\Models\Pelanggan::count() . "\n";
echo "Kunjungan: " . App\Models\KunjunganPelanggan::count() . "\n";
echo "Pembayaran: " . App\Models\PembayaranPelanggan::count() . "\n\n";

echo "=== Pembayaran Breakdown ===\n";
echo "Lancar: " . App\Models\PembayaranPelanggan::lancar()->count() . "\n";
echo "Tertunda (belum overdue): " . App\Models\PembayaranPelanggan::tertunda()
    ->where('tanggal_jatuh_tempo', '>=', now())->count() . "\n";
echo "Overdue: " . App\Models\PembayaranPelanggan::overdue()->count() . "\n\n";

echo "=== Sample Data ===\n";
$pelanggan = App\Models\Pelanggan::with(['wilayah', 'kunjungan', 'pembayaran'])->first();
echo "Sample Pelanggan: {$pelanggan->nama_pelanggan}\n";
echo "  - Wilayah: {$pelanggan->wilayah->nama_wilayah}\n";
echo "  - Total Kunjungan: " . $pelanggan->getVisitCount() . "\n";
echo "  - Total Outstanding: Rp " . number_format($pelanggan->getTotalOutstanding(), 0, ',', '.') . "\n";
echo "  - Total Paid: Rp " . number_format($pelanggan->getTotalPaid(), 0, ',', '.') . "\n";
echo "  - Payment Status: " . $pelanggan->getPaymentStatus() . "\n\n";

echo "=== Week 1 Selesai! All Test Data Ready! ===\n";
