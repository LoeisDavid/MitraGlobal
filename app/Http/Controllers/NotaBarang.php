<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNotaJualDetilRequest;
use App\Http\Requests\UpdateNotaJualDetilRequest;
use App\Models\NotajualDetil_model;
use Illuminate\Http\Request;
use App\Models\NotaJual_model;
use App\Models\Barang_model;
use Illuminate\Support\Facades\DB;

class NotaBarang extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create($kode_nota)
    {
        $barang = Barang_model::select('kode_barang', 'nama', 'harga_jual')->get();
        return view('nota_barang.create', compact('kode_nota', 'barang'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNotaJualDetilRequest $request)
{
    $validated = $request->validated();

    // Ambil barang
    $barang = Barang_model::where('kode_barang', $validated['kode_barang'])->firstOrFail();

    // Validasi stok
    if ($barang->stok < $validated['qty']) {
        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Stok barang tidak mencukupi.');
    }

    // Kurangi stok barang
    $barang->decrement('stok', $validated['qty']);

    // Simpan detail nota
    NotajualDetil_model::create([
        'notajual_no_nota'   => $request->route('id'),
        'barang_kode_barang' => $validated['kode_barang'],
        'harga'              => $barang->harga_jual,
        'jumlah'             => $validated['qty'],
        'diskon'             => $validated['diskon'],
    ]);

    return redirect()
        ->route('nota.show', $request->route('id'))
        ->with('success', 'Barang berhasil ditambahkan ke nota.');
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

    $barang = Barang_model::select('kode_barang', 'nama', 'harga_jual')->get();

    return view('nota_barang.edit', compact('detil', 'no_nota', 'barang'));
}


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNotaJualDetilRequest $request, string $id)
{
    $validated = $request->validated();

    $detil = NotajualDetil_model::with('barang')->findOrFail($id);
    $barangBaru = Barang_model::where('kode_barang', $validated['kode_barang'])->firstOrFail();

    DB::transaction(function () use ($detil, $barangBaru, $validated) {

        $barangLama = $detil->barang;
        $qtyLama    = $detil->jumlah;
        $qtyBaru    = $validated['qty'];

        /**
         * 1️⃣ Kembalikan stok barang lama
         */
        $barangLama->increment('stok', $qtyLama);

        /**
         * 2️⃣ Hitung stok tersedia setelah dikembalikan
         */
        $stokTersedia = $barangBaru->fresh()->stok;

        if ($qtyBaru > $stokTersedia) {
            abort(400, 'Stok barang tidak mencukupi.');
        }

        /**
         * 3️⃣ Kurangi stok barang baru
         */
        $barangBaru->decrement('stok', $qtyBaru);

        /**
         * 4️⃣ Update detail nota
         */
        $detil->update([
            'barang_kode_barang' => $barangBaru->kode_barang,
            'harga'              => $barangBaru->harga_jual,
            'jumlah'             => $qtyBaru,
            'diskon'             => $validated['diskon'],
        ]);
    });

    return redirect()->route('nota.show', $detil->notajual_no_nota);
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
{
    $detil = NotajualDetil_model::with('barang')->findOrFail($id);

    // Kembalikan stok barang
    $detil->barang->increment('stok', $detil->jumlah);

    $no_nota = $detil->notajual_no_nota;

    $detil->delete();

    return redirect()->route('nota.show', $no_nota);
}

}
