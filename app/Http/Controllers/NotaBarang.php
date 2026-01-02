<?php

namespace App\Http\Controllers;

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
    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required|string',
            'qty' => 'required|integer|min:1',
            'diskon' => 'required|numeric|min:0|max:100',
        ]);

        $barang = Barang_model::where('kode_barang', $request->kode_barang)->first();

        if (!$barang || $barang->stok < $request->qty) {
            return redirect()->back()->with('error', 'Stok barang tidak mencukupi.');
        }

        Barang_model::where('kode_barang', $request->kode_barang)->decrement('stok', $request->qty);

        NotajualDetil_model::create([
            'notajual_no_nota' => $request->route('id'),
            'barang_kode_barang' => $request->kode_barang,
            'harga' => $barang->harga_jual,
            'jumlah' => $request->qty,
            'diskon' => $request->diskon,
        ]);

        return redirect()->route('nota.show', $request->route('id'));
    
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
    public function update(Request $request, string $id)
{
    $request->validate([
        'kode_barang' => 'required|string|exists:barang,kode_barang',
        'qty'         => 'required|integer|min:1',
        'diskon'      => 'required|numeric|min:0|max:100',
    ]);

    $detil = NotajualDetil_model::with('barang')->findOrFail($id);
    $barangBaru = Barang_model::where('kode_barang', $request->kode_barang)->firstOrFail();

    DB::transaction(function () use ($request, $detil, $barangBaru) {

        // 1. Kembalikan stok lama
        $detil->barang->increment('stok', $detil->jumlah);

        // 2. Cek stok barang baru
        if ($barangBaru->stok < $request->qty) {
            abort(400, 'Stok barang tidak mencukupi.');
        }

        // 3. Kurangi stok barang baru
        $barangBaru->decrement('stok', $request->qty);

        // 4. Update detil
        $detil->update([
            'barang_kode_barang' => $barangBaru->kode_barang,
            'harga'              => $barangBaru->harga_jual,
            'jumlah'             => $request->qty,
            'diskon'             => $request->diskon,
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
