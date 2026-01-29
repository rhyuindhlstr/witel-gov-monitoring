<?php

namespace App\Http\Controllers;

use App\Models\WilayahGS;
use Illuminate\Http\Request;

class WilayahGSController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wilayahs = WilayahGS::all();
        return view('wilayah-gs.index', compact('wilayahs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('wilayah-gs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_wilayah' => 'required|string|max:255',
            'keterangan'   => 'nullable|string',
        ]);

        WilayahGS::create($validated);

        return redirect()->route('data-wilayah-gs.index')
            ->with('success', 'Wilayah GS successfully created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(WilayahGS $data_wilayah_g)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WilayahGS $data_wilayah_g)
    {
        return view('wilayah-gs.edit', ['wilayah' => $data_wilayah_g]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WilayahGS $data_wilayah_g)
    {
        $validated = $request->validate([
            'nama_wilayah' => 'required|string|max:255',
            'keterangan'   => 'nullable|string',
        ]);

        $data_wilayah_g->update($validated);

        return redirect()->route('data-wilayah-gs.index')
            ->with('success', 'Wilayah GS successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WilayahGS $data_wilayah_g)
    {
        $data_wilayah_g->delete();

        return redirect()->route('data-wilayah-gs.index')
            ->with('success', 'Wilayah GS successfully deleted.');
    }
}
