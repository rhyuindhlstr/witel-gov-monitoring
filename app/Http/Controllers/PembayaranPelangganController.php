<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Imports\PembayaranImport;
use App\Exports\PembayaranExport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use App\Models\PembayaranPelanggan;
use App\Models\Pelanggan;
use Carbon\Carbon;

class PembayaranPelangganController extends Controller
{
    
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = PembayaranPelanggan::with('pelanggan');
        
        // Filter by pelanggan
        if ($request->filled('pelanggan_id')) {
            $query->byPelanggan($request->pelanggan_id);
        }
        
        // Filter by status
        if ($request->filled('status')) {
            if ($request->status == 'overdue') {
                $query->overdue();
            } elseif ($request->status == 'lancar') {
                $query->lancar();
            } elseif ($request->status == 'tertunda') {
                $query->tertunda();
            }
        }
        
        // Filter by date range
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->byDateRange($request->start_date, $request->end_date);
        }
        
        $pembayarans = $query->latest('tanggal_pembayaran')->paginate(20);
        $pelanggans = Pelanggan::all();
        
        return view('ssgs.pembayaran.index', compact('pembayarans', 'pelanggans'));
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
        
        return view('ssgs.pembayaran.create', compact('pelanggans', 'selectedPelanggan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'tanggal_pembayaran' => 'required|date',
            'nominal' => 'required|numeric|min:0',
            'status_pembayaran' => 'required|in:lancar,tertunda',
            'keterangan' => 'nullable|string'
        ]);
        
        // Auto-calculate tanggal_jatuh_tempo (20th of the month)
        $tanggalPembayaran = Carbon::parse($validated['tanggal_pembayaran']);
        $validated['tanggal_jatuh_tempo'] = $tanggalPembayaran->copy()->setDay(20);
        
        PembayaranPelanggan::create($validated);
        
        return redirect()->route('pembayaran.index')
                        ->with('success', 'Data pembayaran berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pembayaran = PembayaranPelanggan::with('pelanggan.wilayah')
                                         ->findOrFail($id);
        
        return view('ssgs.pembayaran.show', compact('pembayaran'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pembayaran = PembayaranPelanggan::findOrFail($id);
        $pelanggans = Pelanggan::all();
        
        return view('ssgs.pembayaran.edit', compact('pembayaran', 'pelanggans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pembayaran = PembayaranPelanggan::findOrFail($id);
        
        $validated = $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'tanggal_pembayaran' => 'required|date',
            'nominal' => 'required|numeric|min:0',
            'status_pembayaran' => 'required|in:lancar,tertunda',
            'keterangan' => 'nullable|string'
        ]);
        
        // Recalculate tanggal_jatuh_tempo if tanggal_pembayaran changed
        $tanggalPembayaran = Carbon::parse($validated['tanggal_pembayaran']);
        $validated['tanggal_jatuh_tempo'] = $tanggalPembayaran->copy()->setDay(20);
        
        $pembayaran->update($validated);
        
        return redirect()->route('pembayaran.index')
                        ->with('success', 'Data pembayaran berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pembayaran = PembayaranPelanggan::findOrFail($id);
        $pembayaran->delete();
        
        return redirect()->route('pembayaran.index')
                        ->with('success', 'Data pembayaran berhasil dihapus');
    }

    /**
     * Menampilkan form untuk import data pembayaran.
     */
    public function showImportForm()
    {
        return view('ssgs.pembayaran.import');
    }

    /**
     * Menangani proses import data dari file Excel.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        try {
            Excel::import(new PembayaranImport, $request->file('file'));
        } catch (ValidationException $e) {
             $failures = $e->failures();
             $errors = [];
             foreach ($failures as $failure) {
                 $errors[] = "Baris " . $failure->row() . ": " . implode(', ', $failure->errors()) . " (nilai: '" . ($failure->values()[$failure->attribute()] ?? 'N/A') . "').";
             }
             return back()->with('import_errors', $errors);
        }

        return redirect()->route('pembayaran.index')->with('success', 'Data pembayaran berhasil diimpor.');
    }

    /**
     * Export data pembayaran ke Excel (dengan filter aktif).
     */
    public function export(Request $request)
    {
        $filters = $request->only(['pelanggan_id', 'status', 'start_date', 'end_date']);
        $filename = 'data-pembayaran-' . now()->format('Y-m-d') . '.xlsx';
        return Excel::download(new PembayaranExport($filters), $filename);
    }
}
