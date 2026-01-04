<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Merk_model;
use Illuminate\Support\Facades\Log;
class Merk extends Controller
{
    /**
     * Display a listing of the resource.
     */

public function index(Request $request)
{
    try {
        $keyword = $request->keyword;

        $query = Merk_model::select('kode_merk', 'nama');

        // SEARCH (dibungkus biar orWhere tidak kabur)
        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('nama', 'like', "%{$keyword}%")
                  ->orWhere('kode_merk', 'like', "%{$keyword}%");
            });
        }

        // URUT A–Z + PAGINATION 10
        $data = $query
            ->orderBy('nama', 'asc')
            ->paginate(10)
            ->appends($request->query());

        return view('merk.index', compact('data', 'keyword'));

    } catch (\Throwable $e) {

        Log::error('Gagal mengambil data merk', [
            'error' => $e->getMessage()
        ]);

        return back()->withErrors([
            'error' => 'Gagal mengambil data merk.'
        ]);
    }
}



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('merk.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
        ]);

        $kode_merk = $this->generateKodeMerk($request->nama);

        
        if ($kode_merk) {
            $merk = Merk_model::where('kode_merk', $kode_merk)->first();
            if ($merk) {
                return redirect()->back()->with('error', 'Kode Merk sudah digunakan.');
            }
        }

        try {

        Merk_model::create([
            'kode_merk' => $kode_merk,
            'nama' => $request->nama,
        ]);

            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data merk: ' . $e->getMessage()]);
            }

        return redirect()->route('merk.index')->with('success', 'Merk berhasil ditambahkan.');
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
        $merk = Merk_model::where('kode_merk', $id)->first();
        if (!$merk) {
            return redirect()->back()->with('error', 'Merk tidak ditemukan.');
        }

        return view('merk.edit', compact('merk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
        ]);

        $merk = Merk_model::where('kode_merk', $id)->first();
        if (!$merk) {
            return redirect()->back()->with('error', 'Merk tidak ditemukan.');
        }

        $kode_merk = $this->generateKodeMerk($request->nama);

        try {
            $existingMerk = Merk_model::where('kode_merk', $kode_merk)
                ->where('kode_merk', '!=', $id)
                ->first();
            if ($existingMerk) {
                return redirect()->back()->with('error', 'Kode/Nama Merk sudah digunakan.');
            }
            $merk->update([
            'kode_merk' => $kode_merk,
            'nama' => $request->nama,
        ]);

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat memeriksa kode merk: ' . $e->getMessage()]);
        }

        return redirect()->route('merk.index')->with('success', 'Merk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
{
    $merk = Merk_model::where('kode_merk', $id)->first();


    if (!$merk) {
        return redirect()->back()->with('error', 'Merk tidak ditemukan.');
    }

    try {
        $relatedBarang = \App\Models\Barang_model::where('merk_kode_merk', $id)->first();
        if ($relatedBarang) {
            return redirect()->back()->with('error', 'Merk tidak dapat dihapus karena masih terkait dengan data barang.');
        } 
        $merk->delete();

    } catch (\Exception $e) {
        return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat memeriksa data terkait: ' . $e->getMessage()]);
    }
   

    return redirect()->route('merk.index')->with('success', 'Merk berhasil dihapus.');
}

}
