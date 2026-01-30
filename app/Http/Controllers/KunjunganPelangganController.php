<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\KunjunganPelanggan;
use App\Models\Pelanggan;
use App\Models\User;

class KunjunganPelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = KunjunganPelanggan::with(['pelanggan', 'user']);
        
        // Filter by pelanggan
        if ($request->filled('pelanggan_id')) {
            $query->byPelanggan($request->pelanggan_id);
        }
        
        // Filter by date range
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->byDateRange($request->start_date, $request->end_date);
        }
        
        // Filter by user (marketing)
        if ($request->filled('user_id')) {
            $query->byUser($request->user_id);
        }

        // Filter by method
        if ($request->filled('metode')) {
            $query->where('metode', $request->metode);
        }
        
        $kunjungans = $query->latest('tanggal_kunjungan')->paginate(20);
        $pelanggans = Pelanggan::all();
        $users = User::where('email', '!=', 'admin@telkom.com')->get();
        
        return view('ssgs.kunjungan.index', compact('kunjungans', 'pelanggans', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $pelanggans = Pelanggan::all();
        $selectedPelanggan = null;
        
        // If coming from pelanggan detail page
        if ($request->filled('pelanggan_id')) {
            $selectedPelanggan = Pelanggan::find($request->pelanggan_id);
        }
        
        return view('ssgs.kunjungan.create', compact('pelanggans', 'selectedPelanggan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'metode' => 'required|in:visit,call,whatsapp',
            'tanggal_kunjungan' => 'required|date',
            'tujuan' => 'required|string',
            // 'hasil_kunjungan' validation removed here, handled manually below
        ]);
        
        // Determine hasil based on method
        $hasil = match($request->metode) {
            'visit' => $request->hasil_visit,
            'call' => $request->hasil_call,
            'whatsapp' => $request->hasil_whatsapp,
            default => null
        };

        if(!$hasil){
            return back()->withErrors(['hasil_kunjungan' => 'Hasil interaksi wajib diisi'])->withInput();
        }

        $validated['hasil_kunjungan'] = $hasil;
        
        // Auto-assign current user
        $validated['user_id'] = auth()->id();
        
        KunjunganPelanggan::create($validated);
        
        return redirect()->route('kunjungan.index')
                        ->with('success', 'Data interaksi berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kunjungan = KunjunganPelanggan::with(['pelanggan.wilayah', 'user'])
                                       ->findOrFail($id);
        
        return view('ssgs.kunjungan.show', compact('kunjungan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kunjungan = KunjunganPelanggan::findOrFail($id);
        $pelanggans = Pelanggan::all();
        
        return view('ssgs.kunjungan.edit', compact('kunjungan', 'pelanggans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $kunjungan = KunjunganPelanggan::findOrFail($id);
        
        $validated = $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'metode' => 'required|in:visit,call,whatsapp',
            'tanggal_kunjungan' => 'required|date',
            'tujuan' => 'required|string',
        ]);

        // Determine hasil based on method
        $hasil = match($request->metode) {
            'visit' => $request->hasil_visit,
            'call' => $request->hasil_call,
            'whatsapp' => $request->hasil_whatsapp,
            default => null
        };

        if(!$hasil){
            return back()->withErrors(['hasil_kunjungan' => 'Hasil interaksi wajib diisi'])->withInput();
        }

        $validated['hasil_kunjungan'] = $hasil;
        
        $kunjungan->update($validated);
        
        return redirect()->route('kunjungan.index')
                        ->with('success', 'Data interaksi berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kunjungan = KunjunganPelanggan::findOrFail($id);
        $kunjungan->delete();
        
        return redirect()->route('kunjungan.index')
                        ->with('success', 'Data interaksi berhasil dihapus');
    }
}
