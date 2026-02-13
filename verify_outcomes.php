<?php

echo "=== Kunjungan Outcome Analysis ===\n\n";

$total = App\Models\KunjunganPelanggan::count();
echo "Total Kunjungan: {$total}\n\n";

// Count by outcome type
$komitmenCount = App\Models\KunjunganPelanggan::where('hasil_kunjungan', 'like', '%berkomitmen%')
    ->orWhere('hasil_kunjungan', 'like', '%memproses pembayaran%')
    ->orWhere('hasil_kunjungan', 'like', '%dijadwalkan%')
    ->count();

$pemutusanCount = App\Models\KunjunganPelanggan::where('hasil_kunjungan', 'like', '%isolir%')
    ->orWhere('hasil_kunjungan', 'like', '%Pemutusan%')
    ->orWhere('hasil_kunjungan', 'like', '%diputus%')
    ->orWhere('hasil_kunjungan', 'like', '%SP %')
    ->count();

$perpanjanganCount = App\Models\KunjunganPelanggan::where('hasil_kunjungan', 'like', '%perpanjangan%')
    ->orWhere('hasil_kunjungan', 'like', '%cicil%')
    ->orWhere('hasil_kunjungan', 'like', '%keringanan%')
    ->count();

echo "Outcome Distribution:\n";
echo "  1. Komitmen Bayar: {$komitmenCount} (" . round($komitmenCount/$total*100) . "%)\n";
echo "  2. Pemutusan WiFi: {$pemutusanCount} (" . round($pemutusanCount/$total*100) . "%)\n";
echo "  3. Minta Perpanjangan: {$perpanjanganCount} (" . round($perpanjanganCount/$total*100) . "%)\n\n";

echo "=== Sample Outcomes ===\n\n";

// Sample komitmen bayar
$komitmen = App\Models\KunjunganPelanggan::where('hasil_kunjungan', 'like', '%berkomitmen%')->first();
if ($komitmen) {
    echo "1. KOMITMEN BAYAR:\n";
    echo "   Pelanggan: {$komitmen->pelanggan->nama_pelanggan}\n";
    echo "   Hasil: {$komitmen->hasil_kunjungan}\n\n";
}

// Sample pemutusan
$putus = App\Models\KunjunganPelanggan::where('hasil_kunjungan', 'like', '%isolir%')->first();
if ($putus) {
    echo "2. PEMUTUSAN WiFi:\n";
    echo "   Pelanggan: {$putus->pelanggan->nama_pelanggan}\n";
    echo "   Hasil: {$putus->hasil_kunjungan}\n\n";
}

// Sample perpanjangan
$extend = App\Models\KunjunganPelanggan::where('hasil_kunjungan', 'like', '%perpanjangan%')->first();
if ($extend) {
    echo "3. MINTA PERPANJANGAN:\n";
    echo "   Pelanggan: {$extend->pelanggan->nama_pelanggan}\n";
    echo "   Hasil: {$extend->hasil_kunjungan}\n\n";
}

echo "=== Data Update Complete! ===\n";
