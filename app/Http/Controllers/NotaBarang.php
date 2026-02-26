<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNotaJualDetilRequest;
use App\Http\Requests\UpdateNotaJualDetilRequest;
use App\Models\NotajualDetil_model;
use Illuminate\Http\Request;
use App\Models\NotaJual_model;
use App\Models\Barang_model;
use App\Models\Merk_model;
use App\Models\Kategori_model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class NotaBarang extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create($kode_nota)
    {
        $merk = Merk_model::select('kode_merk', 'nama')->orderBy('nama')->get();
        $kategori = Kategori_model::select('kode_kategori', 'nama')->orderBy('nama')->get();

        return view('nota_barang.create', compact(
            'kode_nota',
            'merk',
            'kategori'
        ));
    }

    // AJAX Select2 Barang
public function ajaxBarang(Request $request)
{
    $query = Barang_model::query()
        ->select(
            'kode_barang',
            'nama',
            'harga_beli',
            'diskon',
            'stok'
        )
        ->where('stok', '>', 0);

    // SEARCH kode / nama
    if ($request->search) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('kode_barang', 'like', "%{$search}%")
              ->orWhere('nama', 'like', "%{$search}%");
        });
    }

    // FILTER MERK
    if ($request->kode_merk) {
        $query->where('merk_kode_merk', $request->kode_merk);
    }

    // FILTER KATEGORI
    if ($request->kode_kategori) {
        $query->where('kategori_kode_kategori', $request->kode_kategori);
    }

    $barang = $query->paginate(10);

    return response()->json([
        'results' => $barang->map(function ($row) {
            return [
                'id'          => $row->kode_barang,
                'text'        => $row->kode_barang . ' - ' . $row->nama .
                                 ' (Stok: ' . $row->stok . ')' .
                                 ' - Rp ' . number_format($row->harga_beli, 0, ',', '.'),

                // DATA DETAIL UNTUK JS
                'harga_beli'  => $row->harga_beli,
                'diskon'      => $row->diskon ?? 0,
                'stok'        => $row->stok,
            ];
        }),
        'pagination' => [
            'more' => $barang->hasMorePages()
        ]
    ]);
}


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNotaJualDetilRequest $request)
{
    try {
        DB::transaction(function () use ($request) {
            $validated = $request->validated();

            $barang = Barang_model::lockForUpdate()
                ->where('kode_barang', $validated['kode_barang'])
                ->firstOrFail();

            if ($barang->stok < $validated['qty']) {
                throw new \Exception('Stok barang tidak mencukupi');
            }

            $barang->decrement('stok', $validated['qty']);

            NotajualDetil_model::create([
                'notajual_no_nota'    => $request->route('id'),
                'barang_kode_barang'  => $validated['kode_barang'],
                'harga'               => $validated['harga'],
                'jumlah'              => $validated['qty'],
                'diskon'              => $validated['diskon'],
            ]);
        });

        return redirect()
            ->route('nota.show', $request->route('id'))
            ->with('success', 'Barang berhasil ditambahkan ke nota');

    } catch (QueryException $e) {
        DB::rollBack();
        Log::error('DB Error tambah barang nota', ['error' => $e->getMessage()]);

        return back()->withInput()->with(
            'error',
            'Gagal menyimpan data (masalah database)'
        );

    } catch (\Throwable $e) {
        DB::rollBack();
        Log::error('Error tambah barang nota', ['error' => $e->getMessage()]);

        return back()->withInput()->with(
            'error',
            $e->getMessage() ?: 'Terjadi kesalahan saat menambah barang'
        );
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
    $detil = NotajualDetil_model::with('barang')->findOrFail($id);

    $no_nota = $detil->notajual_no_nota;

    $merk = Merk_model::select('kode_merk', 'nama')->orderBy('nama')->get();
    $kategori = Kategori_model::select('kode_kategori', 'nama')->orderBy('nama')->get();

    return view('nota_barang.edit', compact('detil', 'no_nota', 'merk', 'kategori'));
}


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNotaJualDetilRequest $request, string $id)
{
    try {
        $no_nota = NotaJualDetil_model::findOrFail($id)->notajual_no_nota;
        DB::transaction(function () use ($request, $id) {

            $validated = $request->validated();

            $detil = NotajualDetil_model::with('barang')
                ->lockForUpdate()
                ->findOrFail($id);

            $barangLama = $detil->barang;
            $barangBaru = Barang_model::lockForUpdate()
                ->where('kode_barang', $validated['kode_barang'])
                ->firstOrFail();

            // kembalikan stok lama
            $barangLama->increment('stok', $detil->jumlah);

            if ($barangBaru->stok < $validated['qty']) {
                throw new \Exception('Stok barang tidak mencukupi');
            }

            $barangBaru->decrement('stok', $validated['qty']);

            $detil->update([
                'barang_kode_barang' => $barangBaru->kode_barang,
                'harga'              => $barangBaru->harga_jual,
                'jumlah'             => $validated['qty'],
                'diskon'             => $validated['diskon'],
            ]);
        });

        return redirect()
            ->route('nota.show', $no_nota)
            ->with('success', 'Detail nota berhasil diperbarui');

    } catch (QueryException $e) {
        Log::error('DB Error update nota detail', ['error' => $e->getMessage()]);

        return back()->withInput()->with(
            'error',
            'Gagal memperbarui data (database error)'
        );

    } catch (\Throwable $e) {
        Log::error('Error update nota detail', ['error' => $e->getMessage()]);

        return back()->withInput()->with(
            'error',
            $e->getMessage() ?: 'Terjadi kesalahan saat update data'
        );
    }
}



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
{
    try {
        DB::transaction(function () use ($id, &$no_nota) {

            $detil = NotajualDetil_model::with('barang')
                ->lockForUpdate()
                ->findOrFail($id);

            if (!$detil->barang) {
                throw new \Exception('Barang tidak ditemukan');
            }

            $detil->barang->increment('stok', $detil->jumlah);

            $no_nota = $detil->notajual_no_nota;

            $detil->delete();
        });

        return redirect()
            ->route('nota.show', $no_nota)
            ->with('success', 'Barang berhasil dihapus dari nota');

    } catch (\Throwable $e) {
        Log::error('Error hapus nota detail', ['error' => $e->getMessage()]);

        return redirect()
            ->back()
            ->with('error', 'Gagal menghapus barang dari nota');
    }
}


}
