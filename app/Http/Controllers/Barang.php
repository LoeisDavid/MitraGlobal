<?php

namespace App\Http\Controllers;

use App\Models\Barang_model;
use App\Http\Requests\StoreBarangRequest;
use App\Http\Requests\UpdateBarangRequest;
use App\Models\NotajualDetil_model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
    use Illuminate\Database\QueryException;

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
        
        $lowStockBarangs = Barang_model::where('stok', '<', 10)->get();

        return view('barang.index', compact('barangs', 'keyword', 'lowStockBarangs'));

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
    $data = $request->validated();

    // generate kode dulu
    $kodeBarang =
        $data['merk_kode_merk'] . '-' .
        $data['kategori_kode_kategori'] . '-' .
        $this->generateKodeBarang($data['nama']);

    // ambil prefix merk-kategori dari kode
    [$merk, $kategori] = explode('-', $kodeBarang, 3);

    // hitung jumlah barang yang "mirip"
    $count = Barang_model::where('kode_barang', 'LIKE', $merk . '-' . $kategori . '-%')
        ->where('nama', 'LIKE', '%' . $data['nama'] . '%')
        ->count();

    // RULE BISNIS KAMU
    if ($count === 1) {
        return redirect()
            ->back()
            ->withInput()
            ->withErrors([
                'nama' => 'Barang dengan nama, merk, dan kategori yang sama sudah ada.'
            ]);
    }

    // jika 0 atau >1 → lanjut simpan
    $data['kode_barang'] = $kodeBarang;
    Barang_model::create($data);

    return redirect()
        ->route('barang.index')
        ->with('success', 'Data barang berhasil disimpan.');
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
    $data = $request->validated();

    $barang = Barang_model::where('kode_barang', $id)->firstOrFail();

    // generate kode baru
    $kodeBaru =
        $data['merk_kode_merk'] . '-' .
        $data['kategori_kode_kategori'] . '-' .
        $this->generateKodeBarang($data['nama']);

    // validasi duplikat (rule kamu)
    [$merk, $kategori] = explode('-', $kodeBaru, 3);

    $count = Barang_model::where('kode_barang', '!=', $barang->kode_barang)
        ->where('kode_barang', 'LIKE', $merk . '-' . $kategori . '-%')
        ->where('nama', 'LIKE', '%' . $data['nama'] . '%')
        ->count();

    if ($count === 1) {
        return back()
            ->withInput()
            ->withErrors([
                'nama' => 'Barang dengan nama, merk, dan kategori yang sama sudah ada.'
            ]);
    }

    // coba update
    try {
        $data['kode_barang'] = $kodeBaru;
        $barang->update($data);

        return redirect()
            ->route('barang.index')
            ->with('success', 'Data barang berhasil diperbarui.');

    } catch (QueryException $e) {

        // FK constraint / integrity violation (MySQL: 23000)
        if ($e->getCode() === '23000') {
            return back()
                ->withInput()
                ->withErrors([
                    'error' => 'Tidak dapat melakukan update karena barang sudah digunakan di nota.'
                ]);
        }

        // error lain (bukan FK)
        return back()
            ->withInput()
            ->withErrors([
                'error' => 'Gagal memperbarui data barang.'
            ]);
    }
}



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
{
    $barang = Barang_model::where('kode_barang', $id)->firstOrFail();

    // CEK: apakah barang sedang digunakan
    $isUsed = NotajualDetil_model::where('barang_kode_barang', $barang->kode_barang)->exists();

    if ($isUsed) {
        return redirect()
            ->back()
            ->withErrors([
                'error' => 'Barang tidak dapat dihapus karena sedang digunakan pada transaksi.'
            ]);
    }

    // aman dihapus
    $barang->delete();

    return redirect()
        ->route('barang.index')
        ->with('success', 'Data barang berhasil dihapus.');
}

}
