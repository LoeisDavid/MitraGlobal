<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Merk_model;
class Merk extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Merk_model::all();
        return view('merk.index', compact('data'));
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

        $kode_merk = $this->generateCode($request->nama);

        if ($kode_merk) {
            $merk = Merk_model::where('kode_merk', $kode_merk)->first();
            if ($merk) {
                return redirect()->back()->with('error', 'Kode Merk sudah digunakan.');
            }
        }

        Merk_model::create([
            'kode_merk' => $kode_merk,
            'nama' => $request->nama,
        ]);

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
            'kode_merk' => 'required|string|max:10',
            'nama' => 'required|string|max:100',
        ]);

        $merk = Merk_model::where('kode_merk', $id)->first();
        if (!$merk) {
            return redirect()->back()->with('error', 'Merk tidak ditemukan.');
        }

        $merk->update([
            'kode_merk' => $request->kode_merk,
            'nama' => $request->nama,
        ]);

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

    $merk->delete();

    return redirect()->route('merk.index')->with('success', 'Merk berhasil dihapus.');
}

}
