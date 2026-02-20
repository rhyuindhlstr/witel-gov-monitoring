<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan;
use App\Models\Wilayah;
use App\Exports\PelangganExport;
use Maatwebsite\Excel\Facades\Excel;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Pelanggan::with('wilayah');
        
        // Filter by wilayah
        if ($request->filled('wilayah_id')) {
            $query->where('wilayah_id', $request->wilayah_id);
        }
        
        // Search by nama_pelanggan, nama_pic, or no_telepon
        if ($request->filled('search')) {
            $query->search($request->search);
        }
        
        // Filter by overdue payments
        if ($request->filled('overdue') && $request->overdue == '1') {
            $query->withOverduePayments();
        }
        
        $pelanggans = $query->latest()->paginate(20);
        $wilayahs = Wilayah::all();
        
        return view('ssgs.pelanggan.index', compact('pelanggans', 'wilayahs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $wilayahs = Wilayah::all();
        return view('ssgs.pelanggan.create', compact('wilayahs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'nama_pic' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_telepon' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'wilayah_id' => 'required|exists:wilayahs,id',
            'keterangan' => 'nullable|string'
        ]);
        
        Pelanggan::create($validated);
        
        return redirect()->route('pelanggan.index')
                        ->with('success', 'Data pelanggan berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pelanggan = Pelanggan::with(['wilayah', 'kunjungan.user', 'pembayaran'])
                               ->findOrFail($id);
        
        // Calculate stats
        $stats = [
            'total_kunjungan' => $pelanggan->getVisitCount(),
            'last_visit' => $pelanggan->getLastVisitDate(),
            'total_outstanding' => $pelanggan->getTotalOutstanding(),
            'total_paid' => $pelanggan->getTotalPaid(),
            'payment_status' => $pelanggan->getPaymentStatus()
        ];
        
        return view('ssgs.pelanggan.show', compact('pelanggan', 'stats'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $wilayahs = Wilayah::all();
        
        return view('ssgs.pelanggan.edit', compact('pelanggan', 'wilayahs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        
        $validated = $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'nama_pic' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_telepon' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'wilayah_id' => 'required|exists:wilayahs,id',
            'keterangan' => 'nullable|string'
        ]);
        
        $pelanggan->update($validated);
        
        return redirect()->route('pelanggan.index')
                        ->with('success', 'Data pelanggan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        
        // Check if pelanggan has related kunjungan or pembayaran
        if ($pelanggan->kunjungan()->count() > 0 || $pelanggan->pembayaran()->count() > 0) {
            return redirect()->route('pelanggan.index')
                           ->with('error', 'Tidak dapat menghapus pelanggan yang memiliki data kunjungan atau pembayaran');
        }
        
        $pelanggan->delete();
        
        return redirect()->route('pelanggan.index')
                        ->with('success', 'Data pelanggan berhasil dihapus');
    }

    /**
     * Export data pelanggan ke Excel.
     */
    public function export()
    {
        $filename = 'data-pelanggan-' . now()->format('Y-m-d') . '.xlsx';
        return Excel::download(new PelangganExport, $filename);
    }
}
