<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMerkRequest;
use App\Http\Requests\UpdateMerkRequest;
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
    public function store(StoreMerkRequest $request)
    {
        $validated = $request->validated();

        $kode_merk = $this->generateKodeMerk($validated['nama']);

        
        if ($kode_merk) {
            $merk = Merk_model::where('kode_merk', $kode_merk)->first();
            if ($merk) {
                return redirect()->back()->with('error', 'Kode Merk sudah digunakan.');
            }
        }

        try {

        Merk_model::create($validated + ['kode_merk' => $kode_merk]);

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
    public function update(UpdateMerkRequest $request, string $id)
    {
        $validated = $request->validated();

        $merk = Merk_model::where('kode_merk', $id)->first();
        if (!$merk) {
            return redirect()->back()->with('error', 'Merk tidak ditemukan.');
        }

        $kode_merk = $this->generateKodeMerk($validated['nama']);

        try {
            $existingMerk = Merk_model::where('kode_merk', $kode_merk)
                ->where('kode_merk', '!=', $id)
                ->first();
            if ($existingMerk) {
                return redirect()->back()->with('error', 'Kode/Nama Merk sudah digunakan.');
            }
            $merk->update($validated + ['kode_merk' => $kode_merk]);

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
