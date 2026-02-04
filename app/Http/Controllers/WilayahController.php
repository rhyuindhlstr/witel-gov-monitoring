<?php

namespace App\Http\Controllers;

use App\Models\Wilayah;
use Illuminate\Http\Request;

class WilayahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wilayahs = Wilayah::all();
        


        return view('admin.wilayah.index', compact('wilayahs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {


        return view('admin.wilayah.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_wilayah' => 'required|string|max:255',
            'code'         => 'nullable|string|max:255',
            'keterangan'   => 'nullable|string',
        ]);

        Wilayah::create($validated);

        return redirect()->route('wilayah.index')
            ->with('success', 'Wilayah successfully created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Wilayah $wilayah)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Wilayah $wilayah)
    {


        return view('admin.wilayah.edit', compact('wilayah'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Wilayah $wilayah)
    {
        $validated = $request->validate([
            'nama_wilayah' => 'required|string|max:255',
            'code'         => 'nullable|string|max:255',
            'keterangan'   => 'nullable|string',
        ]);

        $wilayah->update($validated);

        return redirect()->route('wilayah.index')
            ->with('success', 'Wilayah successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Wilayah $wilayah)
    {
        $wilayah->delete();

        return redirect()->route('wilayah.index')
            ->with('success', 'Wilayah successfully deleted.');
    }
}
