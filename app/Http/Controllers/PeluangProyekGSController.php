<?php

namespace App\Http\Controllers;

use App\Models\PeluangProyekGS;
use App\Models\Wilayah;
use App\Models\PeluangProyekGSLog;
use App\Exports\PeluangProyekGSExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class PeluangProyekGSController extends Controller
{
    public function index(Request $request)
    {
        $peluang = PeluangProyekGS::with('wilayah')
            ->when($request->status, fn($q) =>
                $q->where('status_proyek', $request->status))
            ->when($request->wilayah, fn($q) =>
                $q->where('wilayah_id', $request->wilayah))
            ->latest()
            ->get();

        $wilayahs = Wilayah::all();

        return view('peluang-gs.index', compact('peluang', 'wilayahs'));
    }

    public function create()
    {
        $wilayahs = Wilayah::orderBy('nama_wilayah')->get();
        return view('peluang-gs.create', compact('wilayahs'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['nilai_estimasi']  = $this->cleanRupiah($request->nilai_estimasi);
        $data['nilai_realisasi'] = $this->cleanRupiah($request->nilai_realisasi);
        $data['nilai_scaling']   = $this->cleanRupiah($request->nilai_scaling);
        $data['tanggal_input']   = now()->toDateString();

        $peluang = PeluangProyekGS::create($data);

        PeluangProyekGSLog::create([
            'peluang_proyek_gs_id' => $peluang->id,
            'user_id' => Auth::id(),
            'aksi' => 'CREATE',
            'data_baru' => $peluang->toArray(),
        ]);

        return redirect()->route('peluang-gs.index')->with('success','Data berhasil disimpan');
    }

    public function show(PeluangProyekGS $peluang_g)
    {
        $logs = PeluangProyekGSLog::where('peluang_proyek_gs_id',$peluang_g->id)
            ->latest()->get();

        return view('peluang-gs.show', compact('peluang_g','logs'));
    }

    public function edit(PeluangProyekGS $peluang_g)
    {
        $wilayahs = Wilayah::all();
        return view('peluang-gs.edit', compact('peluang_g','wilayahs'));
    }

public function update(Request $request, PeluangProyekGS $peluang_g)
{
    $request->validate([
        'wilayah_id'    => 'required|exists:wilayahs,id',
        'judul_proyek'  => 'required|string',
        'status_proyek' => 'required|string',
    ]);

    $peluang_g->update([
        'wilayah_id'          => $request->wilayah_id,
        'id_am'               => $request->id_am,
        'nama_am'             => $request->nama_am,
        'nama_gc'             => $request->nama_gc,
        'satker'              => $request->satker,
        'judul_proyek'        => $request->judul_proyek,
        'jenis_layanan'       => $request->jenis_layanan,
        'jenis_proyek'        => $request->jenis_proyek,
        'nilai_estimasi'      => $this->cleanRupiah($request->nilai_estimasi),
        'nilai_realisasi'     => $this->cleanRupiah($request->nilai_realisasi),
        'nilai_scaling'       => $this->cleanRupiah($request->nilai_scaling),
        'status_mytens'       => $request->status_mytens,
        'status_proyek'       => $request->status_proyek,
        'mekanisme_pengadaan' => $request->mekanisme_pengadaan,
        'start_pelaksanaan'   => $request->start_pelaksanaan,
        'end_pelaksanaan'     => $request->end_pelaksanaan,
        'keterangan'          => $request->keterangan,
    ]);

    return redirect()
        ->route('peluang-gs.index')
        ->with('success_update', 'Data peluang proyek berhasil diperbarui');
}
    public function destroy(PeluangProyekGS $peluang_g)
    {
        PeluangProyekGSLog::create([
            'peluang_proyek_gs_id' => $peluang_g->id,
            'user_id' => Auth::id(),
            'aksi' => 'DELETE',
            'data_lama' => $peluang_g->toArray(),
        ]);

        $peluang_g->delete();
        return back()->with('success','Data dihapus');
    }

    public function export()
    {
        return Excel::download(new PeluangProyekGSExport,'peluang_proyek_gs.xlsx');
    }

    public function exportPdf(PeluangProyekGS $peluang_g)
    {
        $pdf = Pdf::loadView('peluang-gs.pdf', compact('peluang_g'));
        return $pdf->download('Detail_'.$peluang_g->judul_proyek.'.pdf');
    }

    private function cleanRupiah($v)
    {
        return (int) preg_replace('/[^0-9]/','',$v);
    }
}
