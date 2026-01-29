<?php

namespace App\Http\Controllers;

use App\Models\Wilayah;
use Illuminate\Http\Request;

class WilayahController extends Controller
{
    public function index()
    {
        $wilayahs = Wilayah::latest()->get();
        return view('wilayah.index', compact('wilayahs'));
    }

    public function create()
    {
        return view('wilayah.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_wilayah' => 'required|string|max:100',
        ]);

        Wilayah::create($request->all());

        return redirect()
            ->route('wilayah.index')
            ->with('success', 'Wilayah berhasil ditambahkan');
    }

    public function show(Wilayah $wilayah)
    {
        return view('wilayah.show', compact('wilayah'));
    }

    public function edit(Wilayah $wilayah)
    {
        return view('wilayah.edit', compact('wilayah'));
    }

    public function update(Request $request, Wilayah $wilayah)
    {
        $request->validate([
            'nama_wilayah' => 'required|string|max:100',
        ]);

        $wilayah->update($request->all());

        return redirect()
            ->route('wilayah.index')
            ->with('success', 'Wilayah berhasil diperbarui');
    }

    public function destroy(Wilayah $wilayah)
    {
        $wilayah->delete();

        return redirect()
            ->route('wilayah.index')
            ->with('success', 'Wilayah berhasil dihapus');
    }
}
