<?php

namespace App\Http\Controllers;

use App\Models\AktivitasMarketing;
use App\Models\PeluangProyekGS;
use Illuminate\Http\Request;

class AktivitasMarketingController extends Controller
{
    /* =========================
     * INDEX
     * ========================= */
    public function index(Request $request)
    {
        $query = AktivitasMarketing::with('peluang.wilayah');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('peluang', function($q) use ($search) {
                $q->where('nama_am', 'like', "%{$search}%")
                  ->orWhere('id_am', 'like', "%{$search}%");
            });
        }

        $aktivitas = $query->orderByDesc('tanggal')->get();

        return view('aktivitas_marketing.index', compact('aktivitas'));
    }

    /* =========================
     * CREATE
     * ========================= */
    public function create()
    {
        $peluang = PeluangProyekGS::with('wilayah')
            ->orderBy('judul_proyek')
            ->get();

        return view('aktivitas_marketing.create', compact('peluang'));
    }

    /* =========================
     * STORE
     * ========================= */
    public function store(Request $request)
    {
        $request->validate([
            'peluang_proyek_gs_id' => 'required|exists:peluang_proyek_gs,id',
            'tanggal'             => 'required|date',
            'jenis_aktivitas'     => 'required|string',
            'hasil'               => 'required|string',
            'keterangan'          => 'nullable|string',
        ]);

        AktivitasMarketing::create([
            'peluang_proyek_gs_id' => $request->peluang_proyek_gs_id,
            'tanggal'              => $request->tanggal,
            'jenis_aktivitas'      => $request->jenis_aktivitas,
            'hasil'                => $request->hasil,
            'keterangan'           => $request->keterangan,
        ]);

        return redirect()
            ->route('aktivitas-marketing.index')
            ->with('success', 'Aktivitas marketing berhasil ditambahkan');
    }

    /* =========================
     * SHOW
     * ========================= */
    public function show(AktivitasMarketing $aktivitas_marketing)
    {
        $aktivitas_marketing->load('peluang.wilayah');

        return view('aktivitas_marketing.show', compact('aktivitas_marketing'));
    }

    /* =========================
     * EDIT
     * ========================= */
    public function edit(AktivitasMarketing $aktivitas_marketing)
    {
        $peluang = PeluangProyekGS::with('wilayah')
            ->orderBy('judul_proyek')
            ->get();

        return view(
            'aktivitas_marketing.edit',
            compact('aktivitas_marketing', 'peluang')
        );
    }

    /* =========================
     * UPDATE
     * ========================= */
    public function update(Request $request, AktivitasMarketing $aktivitas_marketing)
    {
        $request->validate([
            'peluang_proyek_gs_id' => 'required|exists:peluang_proyek_gs,id',
            'tanggal'             => 'required|date',
            'jenis_aktivitas'     => 'required|string',
            'hasil'               => 'required|string',
            'keterangan'          => 'nullable|string',
        ]);

        $aktivitas_marketing->update([
            'peluang_proyek_gs_id' => $request->peluang_proyek_gs_id,
            'tanggal'              => $request->tanggal,
            'jenis_aktivitas'      => $request->jenis_aktivitas,
            'hasil'                => $request->hasil,
            'keterangan'           => $request->keterangan,
        ]);

        return redirect()
            ->route('aktivitas-marketing.index')
            ->with('success', 'Aktivitas marketing berhasil diperbarui');
    }

    /* =========================
     * DESTROY
     * ========================= */
    public function destroy(AktivitasMarketing $aktivitas_marketing)
    {
        $aktivitas_marketing->delete();

        return back()->with('success', 'Aktivitas marketing berhasil dihapus');
    }
}
