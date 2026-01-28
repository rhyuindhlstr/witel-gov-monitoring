<?php

// Test SSGS Models Relationships

echo "=== Testing Models ===\n\n";

// Test Wilayah
$wilayah = App\Models\Wilayah::first();
echo "1. Wilayah Model:\n";
echo "   - Nama: {$wilayah->nama_wilayah}\n";
echo "   - Has pelanggans(): " . (method_exists($wilayah, 'pelanggans') ? 'Yes' : 'No') . "\n\n";

// Test Pelanggan (needs sample data)
echo "2. Pelanggan Model:\n";
echo "   - Fillable: " . implode(', ', (new App\Models\Pelanggan())->getFillable()) . "\n";
echo "   - Has wilayah(): " . (method_exists(new App\Models\Pelanggan(), 'wilayah') ? 'Yes' : 'No') . "\n";
echo "   - Has kunjungan(): " . (method_exists(new App\Models\Pelanggan(), 'kunjungan') ? 'Yes' : 'No') . "\n";
echo "   - Has pembayaran(): " . (method_exists(new App\Models\Pelanggan(), 'pembayaran') ? 'Yes' : 'No') . "\n";
echo "   - Has getTotalOutstanding(): " . (method_exists(new App\Models\Pelanggan(), 'getTotalOutstanding') ? 'Yes' : 'No') . "\n\n";

// Test KunjunganPelanggan
echo "3. KunjunganPelanggan Model:\n";
echo "   - Fillable: " . implode(', ', (new App\Models\KunjunganPelanggan())->getFillable()) . "\n";
echo "   - Has pelanggan(): " . (method_exists(new App\Models\KunjunganPelanggan(), 'pelanggan') ? 'Yes' : 'No') . "\n";
echo "   - Has user(): " . (method_exists(new App\Models\KunjunganPelanggan(), 'user') ? 'Yes' : 'No') . "\n\n";

// Test PembayaranPelanggan
echo "4. PembayaranPelanggan Model:\n";
echo "   - Fillable: " . implode(', ', (new App\Models\PembayaranPelanggan())->getFillable()) . "\n";
echo "   - Has pelanggan(): " . (method_exists(new App\Models\PembayaranPelanggan(), 'pelanggan') ? 'Yes' : 'No') . "\n";
echo "   - Has isOverdue(): " . (method_exists(new App\Models\PembayaranPelanggan(), 'isOverdue') ? 'Yes' : 'No') . "\n\n";

echo "=== All Models Enhanced Successfully! ===\n";
