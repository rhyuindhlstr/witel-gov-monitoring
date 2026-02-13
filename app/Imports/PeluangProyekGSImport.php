<?php

namespace App\Imports;

use App\Models\PeluangProyekGS;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PeluangProyekGSImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Pastikan nama kolom di Excel (header) sesuai dengan key array di bawah (lowercase)
        return new PeluangProyekGS([
            'wilayah_id'          => $row['wilayah_id'] ?? null,
            'id_am'               => $row['id_am'] ?? null,
            'nama_am'             => $row['nama_am'] ?? null,
            'nama_gc'             => $row['nama_gc'] ?? null,
            'satker'              => $row['satker'] ?? null,
            'judul_proyek'        => $row['judul_proyek'] ?? 'Proyek Tanpa Judul',
            'jenis_layanan'       => $row['jenis_layanan'] ?? null,
            'jenis_proyek'        => $row['jenis_proyek'] ?? null,
            'nilai_estimasi'      => $row['nilai_estimasi'] ?? 0,
            'nilai_realisasi'     => $row['nilai_realisasi'] ?? 0,
            'nilai_scaling'       => $row['nilai_scaling'] ?? 0,
            'status_mytens'       => $row['status_mytens'] ?? null,
            'status_proyek'       => $row['status_proyek'] ?? 'PROSPECT',
            'mekanisme_pengadaan' => $row['mekanisme_pengadaan'] ?? null,
            'start_pelaksanaan'   => $this->transformDate($row['start_pelaksanaan'] ?? null),
            'end_pelaksanaan'     => $this->transformDate($row['end_pelaksanaan'] ?? null),
            'keterangan'          => $row['keterangan'] ?? null,
            'tanggal_input'       => now(),
        ]);
    }

    /**
     * Helper untuk konversi tanggal Excel ke format Y-m-d
     */
    private function transformDate($value)
    {
        if (!$value) return null;
        try {
            return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
        } catch (\Exception $e) {
            return null;
        }
    }
}