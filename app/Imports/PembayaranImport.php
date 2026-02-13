<?php

namespace App\Imports;

use App\Models\PembayaranPelanggan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Carbon\Carbon;

class PembayaranImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new PembayaranPelanggan([
            'pelanggan_id'       => $row['pelanggan_id'],
            'tanggal_pembayaran' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_pembayaran'])),
            'nominal'            => $row['nominal'],
            'status_pembayaran'  => $row['status_pembayaran'] ?? 'lancar',
            'keterangan'         => $row['keterangan'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'tanggal_pembayaran' => 'required',
            'nominal' => 'required|numeric',
            'status_pembayaran' => 'nullable|in:lancar,tertunda',
        ];
    }
}
