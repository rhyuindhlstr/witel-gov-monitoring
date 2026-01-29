<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: DejaVu Sans; font-size: 12px; }
        table { width:100%; border-collapse: collapse; }
        th, td { border:1px solid #000; padding:6px; }
        th { background:#f2f2f2; text-align:left; }
    </style>
</head>
<body>

<h3>Detail Peluang Proyek GS</h3>

<table>
<tr><th>Wilayah</th><td>{{ $peluang_g->wilayah->nama_wilayah ?? '-' }}</td></tr>
<tr><th>Judul Proyek</th><td>{{ $peluang_g->judul_proyek }}</td></tr>
<tr><th>Satker</th><td>{{ $peluang_g->satker }}</td></tr>
<tr><th>Status</th><td>{{ $peluang_g->status_proyek }}</td></tr>
<tr><th>Estimasi</th><td>Rp {{ number_format($peluang_g->nilai_estimasi,0,',','.') }}</td></tr>
<tr><th>Realisasi</th><td>Rp {{ number_format($peluang_g->nilai_realisasi,0,',','.') }}</td></tr>
<tr><th>Keterangan</th><td>{{ $peluang_g->keterangan }}</td></tr>
</table>

</body>
</html>
