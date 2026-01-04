<?php

namespace App\Http\Controllers;

use App\Models\Barang_model;
use App\Http\Requests\StoreBarangRequest;
use App\Http\Requests\UpdateBarangRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Barang extends Controller
{
    /**
     * Display a listing of the resource.
     */

public function index(Request $request)
{
    try {
        $keyword = $request->keyword;

        $query = Barang_model::with(['merk', 'kategori']);

        // SEARCH
        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('nama', 'like', "%{$keyword}%")
                  ->orWhereHas('merk', function ($q2) use ($keyword) {
                      $q2->where('nama', 'like', "%{$keyword}%");
                  })
                  ->orWhereHas('kategori', function ($q3) use ($keyword) {
                      $q3->where('nama', 'like', "%{$keyword}%");
                  });
            });
        }

        // TERBARU + PAGINATION
        $barangs = $query
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->appends($request->query());

        return view('barang.index', compact('barangs', 'keyword'));

    } catch (\Throwable $e) {

        Log::error('Gagal mengambil data barang', [
            'error' => $e->getMessage()
        ]);

        return back()->withErrors([
            'error' => 'Gagal mengambil data barang.'
        ]);
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
            $barang = Barang_model::create($data);

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
