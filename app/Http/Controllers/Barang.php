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
        try {
            $barangs = Barang_model::with(['merk', 'kategori'])->get();

        return view('barang.index', compact('barangs'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat mengambil data barang: ' . $e->getMessage()]);
        }
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $merks = \App\Models\Merk_model::all();
            $kategoris = \App\Models\Kategori_model::all();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat mengambil data merk atau kategori: ' . $e->getMessage()]);
        }
        $merks = \App\Models\Merk_model::all();
        $kategoris = \App\Models\Kategori_model::all();
        return view('barang.create', compact('merks', 'kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBarangRequest $request)
    {
        try {
            $data = $request->validated();
            $data['kode_barang'] = $data['merk_kode_merk'].'-'.$data['kategori_kode_kategori'].'-'.$this->generateKodeBarang($data['nama']);
            Barang_model::create($data);

            return redirect()->route('barang.index')->with('success', 'Data barang berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data barang: ' . $e->getMessage()]);
        }
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

        try {
            $barang = Barang_model::where('kode_barang', $id)->firstOrFail();
            $kategoris = \App\Models\Kategori_model::all();
            $merks = \App\Models\Merk_model::all();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat mengambil data barang, merk, atau kategori: ' . $e->getMessage()]);
        }
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

        try {
            $data = $request->validated();
            $barang = Barang_model::where('kode_barang', $id)->firstOrFail();
            $data['kode_barang'] = $data['merk_kode_merk'].'-'.$data['kategori_kode_kategori'].'-'.$this->generateKodeBarang($data['nama']);
            $barang->update($data);

            return redirect()->route('barang.index')->with('success', 'Data barang berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui data barang: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $barang = Barang_model::where('kode_barang', $id)->firstOrFail();
            $barang->delete();

            return redirect()->route('barang.index')->with('success', 'Data barang berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menghapus data barang: ' . $e->getMessage()]);
        }
    }
}
