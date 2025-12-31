<?php

namespace App\Http\Controllers;

use App\Models\Barang_model;
use App\Http\Requests\StoreBarangRequest;
use App\Http\Requests\UpdateBarangRequest;

class Barang extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barang = Barang_model::with(['merk', 'kategori'])->get();

        return route('barang.index', compact('barang'));
    }

    /**
     * Show the form for creating a new resource.
     * (biasanya kosong kalau API)
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBarangRequest $request)
    {
        $barang = Barang_model::create($request->validated());

        return route('barang.show', ['barang' => $barang->kode_barang]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $barang = Barang_model::with(['merk', 'kategori'])
            ->where('kode_barang', $id)
            ->firstOrFail();

        return route('barang.show', compact('barang'));
    }

    /**
     * Show the form for editing the specified resource.
     * (API juga biasanya kosong)
     */
    public function edit(string $id)
    {
        $barang = Barang_model::where('kode_barang', $id)->firstOrFail();

        return route('barang.edit', compact('barang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBarangRequest $request, string $id)
    {
        $barang = Barang_model::where('kode_barang', $id)->firstOrFail();
        $barang->update($request->validated());

        return route('barang.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $barang = Barang_model::where('kode_barang', $id)->firstOrFail();
        $barang->delete();

        return route('barang.index');
    }
}
