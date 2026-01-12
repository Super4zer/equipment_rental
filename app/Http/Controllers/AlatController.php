<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Kategori;
use Illuminate\Http\Request;

class AlatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alats = Alat::with('kategori')->get();
        return view('admin.alat.index', compact('alats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = Kategori::all();
        return view('admin.alat.create', compact('kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_alat' => 'required',
            'kategori_id' => 'required|exists:kategoris,id',
            'stok' => 'required|integer|min:0',
            'harga_sewa_per_hari' => 'required|numeric|min:0',
            'deskripsi' => 'nullable',
            'gambar' => 'nullable|url' // Assuming URL for now based on typical seeder patterns, can upgrade to image file later
        ]);

        Alat::create($request->all());

        return redirect()->route('alat.index')->with('success', 'Alat created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Alat $alat)
    {
        return view('admin.alat.show', compact('alat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Alat $alat)
    {
        $kategoris = Kategori::all();
        return view('admin.alat.edit', compact('alat', 'kategoris'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Alat $alat)
    {
        $request->validate([
            'nama_alat' => 'required',
            'kategori_id' => 'required|exists:kategoris,id',
            'stok' => 'required|integer|min:0',
            'harga_sewa_per_hari' => 'required|numeric|min:0',
            'deskripsi' => 'nullable',
            'gambar' => 'nullable|url'
        ]);

        $alat->update($request->all());

        return redirect()->route('alat.index')->with('success', 'Alat updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Alat $alat)
    {
        $alat->delete();
        return redirect()->route('alat.index')->with('success', 'Alat deleted successfully');
    }
}
