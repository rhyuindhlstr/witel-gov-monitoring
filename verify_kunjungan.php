<?php

echo "=== Updated Database Summary ===\n\n";

echo "Kunjungan Total: " . App\Models\KunjunganPelanggan::count() . "\n";
echo "Pembayaran Tertunda: " . App\Models\PembayaranPelanggan::where('status_pembayaran', 'tertunda')->count() . "\n\n";

echo "=== Business Rule Verification ===\n";
echo "Rule: Kunjungan 1x per bulan untuk pelanggan dengan tagihan tertunda\n\n";

// Show sample kunjungan
$sample = App\Models\KunjunganPelanggan::with(['pelanggan', 'user'])->first();
if ($sample) {
    echo "Sample Kunjungan:\n";
    echo "  - Pelanggan: {$sample->pelanggan->nama_pelanggan}\n";
    echo "  - Tanggal: {$sample->tanggal_kunjungan->format('d M Y')}\n";
    echo "  - Tujuan: {$sample->tujuan}\n";
    echo "  - Petugas: {$sample->user->name}\n";
    echo "  - Hasil: " . substr($sample->hasil_kunjungan, 0, 100) . "...\n\n";
}

// Check if all kunjungan are for follow-up pembayaran
$followUpCount = App\Models\KunjunganPelanggan::where('tujuan', 'like', 'Follow-up pembayaran%')->count();
echo "Kunjungan untuk follow-up pembayaran: {$followUpCount} dari " . App\Models\KunjunganPelanggan::count() . "\n";

// Verify 1 visit per pelanggan per month
echo "\n=== Checking 1 Visit Per Month Rule ===\n";
$duplicates = App\Models\KunjunganPelanggan::selectRaw('pelanggan_id, YEAR(tanggal_kunjungan) as year, MONTH(tanggal_kunjungan) as month, COUNT(*) as count')
    ->groupBy('pelanggan_id', 'year', 'month')
    ->having('count', '>', 1)
    ->count();

if ($duplicates == 0) {
    echo "✓ Rule verified: No duplicate visits per pelanggan per month\n";
} else {
    echo "✗ Found {$duplicates} pelanggan with multiple visits in same month\n";
}

echo "\n=== Data Update Complete ===\n";
