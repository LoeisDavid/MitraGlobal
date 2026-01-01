<?php

namespace App\Http\Controllers;

use App\Models\Barang_model;
use App\Http\Requests\StoreBarangRequest;
use App\Http\Requests\UpdateBarangRequest;
use Illuminate\Http\Request;

class Barang extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barangs = Barang_model::with(['merk', 'kategori'])->get();

        return view('barang.index', compact('barangs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $merks = \App\Models\Merk_model::all();
        $kategoris = \App\Models\Kategori_model::all();
        return view('barang.create', compact('merks', 'kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBarangRequest $request)
    {
        $data = $request->validated();
        $barang = Barang_model::create($data);

        return view('barang.index', ['barang' => $barang->kode_barang]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * (API juga biasanya kosong)
     */
    public function edit(string $id)
    {
        $barang = Barang_model::where('kode_barang', $id)->firstOrFail();
        $kategoris = \App\Models\Kategori_model::all();
        $merks = \App\Models\Merk_model::all();

        return view('barang.edit', compact('barang', 'kategoris', 'merks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBarangRequest $request, string $id)
    {
        $data = $request->validated();
        $barang = Barang_model::where('kode_barang', $id)->firstOrFail();
        $barang->update($data);

        return redirect()->route('barang.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $barang = Barang_model::where('kode_barang', $id)->firstOrFail();
        $barang->delete();

        return redirect()->route('barang.index');
    }
}
