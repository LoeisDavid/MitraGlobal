<?php

namespace App\Http\Controllers;

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
    public function store(Request $request)
    {
        $request->validate([
            'kode_kategori' => 'required|unique:kategori,kode_kategori',
            'nama' => 'required',
        ]);

        Kategori_model::create([
            'kode_kategori' => Str::upper($request->kode_kategori),
            'nama' => $request->nama,
        ]);

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
            'kode_kategori' => 'required|unique:kategori,kode_kategori' . $id . ',kode_kategori',
            'nama' => 'required',
        ]);

        Kategori_model::where('kode_kategori', $id)->update([
            'kode_kategori' => Str::upper($request->kode_kategori),
            'nama' => $request->nama,
        ]);

        return redirect()->route('kategori.index');
    }

    public function destroy(string $id)
    {
        Kategori_model::where('kode_kategori', $id)->delete();
        return redirect()->route('kategori.index');
    }
}
