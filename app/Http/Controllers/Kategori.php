<?php

namespace App\Http\Controllers;

use App\Models\Kategori_model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class Kategori extends Controller
{
    /**
     * Display a listing of the resource.
     */

public function index(Request $request)
{
    try {
        $keyword = $request->keyword;

        $query = Kategori_model::select('kode_kategori', 'nama');

        // SEARCH (dibungkus supaya orWhere tidak liar)
        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('nama', 'like', "%{$keyword}%")
                  ->orWhere('kode_kategori', 'like', "%{$keyword}%");
            });
        }

        // URUTKAN A–Z + PAGINATION 10
        $kategori = $query
            ->orderBy('nama', 'asc')
            ->paginate(10)
            ->appends($request->query());

        return view('kategori.index', compact('kategori', 'keyword'));

    } catch (\Throwable $e) {

        Log::error('Gagal mengambil data kategori', [
            'error' => $e->getMessage()
        ]);

        return back()->withErrors([
            'error' => 'Gagal mengambil data kategori.'
        ]);
    }
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
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
        ]);

        $kode_kategori = $this->generateKodeKategori($request->nama);

        try {
            Kategori_model::create([
                'kode_kategori' => Str::upper($kode_kategori),
                'nama' => $request->nama,
            ]);

            return redirect()->route('kategori.index')->with('success', 'Data kategori berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data kategori: ' . $e->getMessage()]);
        }

        return redirect()->route('kategori.index');
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
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama' => 'required',
        ]);

        $kode_kategori = $this->generateKodeKategori($request->nama);

        try {
            Kategori_model::where('kode_kategori', $id)->update([
                'kode_kategori' => Str::upper($kode_kategori),
                'nama' => $request->nama,
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
        
        return redirect()->route('kategori.index');
    }
}
