<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKategoriRequest;
use App\Http\Requests\UpdateKategoriRequest;
use App\Models\Kategori_model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Kategori extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategori = Kategori_model::select('kode_kategori', 'nama')->get();
        return view('kategori.index', compact('kategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategori = Kategori_model::select('kode_kategori', 'nama')->get();
        return view('kategori.create', compact('kategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKategoriRequest $request)
    {
        $validated = $request->validated();

        $kode_kategori = $this->generateKodeKategori($validated['nama']);

        try {
            Kategori_model::create([
                'kode_kategori' => Str::upper($kode_kategori),
                'nama' => $validated['nama'],
            ]);

            return redirect()->route('kategori.index')->with('success', 'Data kategori berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data kategori: ' . $e->getMessage()]);
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
     */
    public function edit(string $id)
    {
        $kategori = Kategori_model::where('kode_kategori', $id)->firstOrFail();
        return view('kategori.edit', compact('kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKategoriRequest $request, string $id)
    {
        $validated = $request->validated();

        $kode_kategori = $this->generateKodeKategori($validated['nama']);

        try {
            Kategori_model::where('kode_kategori', $id)->update([
                'kode_kategori' => Str::upper($kode_kategori),
                'nama' => $validated['nama'],
            ]);

            return redirect()->route('kategori.index')->with('success', 'Data kategori berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui data kategori: ' . $e->getMessage()]);
        }
    }

    public function destroy(string $id)
    {
        try {
            Kategori_model::where('kode_kategori', $id)->firstOrFail();

            $relatedBarang = \App\Models\Barang_model::where('kategori_kode_kategori', $id)->first();
            if ($relatedBarang) {
                return redirect()->back()->with('error', 'Kategori tidak dapat dihapus karena masih terkait dengan data barang.');
            }

            Kategori_model::where('kode_kategori', $id)->delete();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat mengambil data kategori: ' . $e->getMessage()]);
        }

        return redirect()->route('kategori.index')->with('success', 'Data kategori berhasil dihapus.'); 
    }
}
