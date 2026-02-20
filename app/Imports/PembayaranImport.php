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
        // Handle both Excel serial dates (number) and plain text dates (string)
        $tanggal = $row['tanggal_pembayaran'];
        if (is_numeric($tanggal)) {
            $tanggal = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($tanggal));
        } else {
            $tanggal = Carbon::parse($tanggal);
        }

        return new PembayaranPelanggan([
            'pelanggan_id'       => $row['pelanggan_id'],
            'tanggal_pembayaran' => $tanggal,
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
