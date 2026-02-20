<?php

namespace App\Exports;

use App\Models\PembayaranPelanggan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Http\Request;

class PembayaranExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = PembayaranPelanggan::with('pelanggan');

        if (!empty($this->filters['pelanggan_id'])) {
            $query->byPelanggan($this->filters['pelanggan_id']);
        }

        if (!empty($this->filters['status'])) {
            if ($this->filters['status'] === 'overdue') $query->overdue();
            elseif ($this->filters['status'] === 'lancar') $query->lancar();
            elseif ($this->filters['status'] === 'tertunda') $query->tertunda();
        }

        if (!empty($this->filters['start_date']) && !empty($this->filters['end_date'])) {
            $query->byDateRange($this->filters['start_date'], $this->filters['end_date']);
        }

        return $query->latest('tanggal_pembayaran')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Pelanggan',
            'Tanggal Pembayaran',
            'Nominal',
            'Status',
            'Jatuh Tempo',
            'Keterangan',
        ];
    }

    public function map($pembayaran): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $pembayaran->pelanggan->nama_pelanggan ?? '-',
            $pembayaran->tanggal_pembayaran ? $pembayaran->tanggal_pembayaran->format('d/m/Y') : '-',
            $pembayaran->nominal,
            ucfirst($pembayaran->status_pembayaran),
            $pembayaran->tanggal_jatuh_tempo ? $pembayaran->tanggal_jatuh_tempo->format('d/m/Y') : '-',
            $pembayaran->keterangan ?? '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font'      => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill'      => ['fillType' => 'solid', 'startColor' => ['argb' => 'FFCC0000']],
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }
}
