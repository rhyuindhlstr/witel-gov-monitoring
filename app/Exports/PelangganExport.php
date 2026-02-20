<?php

namespace App\Exports;

use App\Models\Pelanggan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PelangganExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    public function collection()
    {
        return Pelanggan::with('wilayah')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Pelanggan',
            'Nama PIC',
            'No. Telepon',
            'Email',
            'Alamat',
            'Wilayah',
            'Keterangan',
        ];
    }

    public function map($pelanggan): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $pelanggan->nama_pelanggan,
            $pelanggan->nama_pic,
            $pelanggan->no_telepon,
            $pelanggan->email ?? '-',
            $pelanggan->alamat,
            $pelanggan->wilayah->nama_wilayah ?? '-',
            $pelanggan->keterangan ?? '-',
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
