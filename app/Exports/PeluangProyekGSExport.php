<?php

namespace App\Exports;

use App\Models\PeluangProyekGS;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PeluangProyekGSExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return PeluangProyekGS::with('wilayah')->get()->map(function ($item) {
            return [
                'Wilayah'        => $item->wilayah->nama_wilayah ?? '-',
                'ID AM'          => $item->id_am,
                'Nama AM'        => $item->nama_am,
                'Satker'         => $item->satker,
                'Judul Proyek'   => $item->judul_proyek,
                'Status Proyek'  => $item->status_proyek,
                'Status MyTens'  => $item->status_mytens,
                'Nilai Estimasi' => $item->nilai_estimasi,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Wilayah',
            'ID AM',
            'Nama AM',
            'Satker',
            'Judul Proyek',
            'Status Proyek',
            'Status MyTens',
            'Nilai Estimasi',
        ];
    }
}
