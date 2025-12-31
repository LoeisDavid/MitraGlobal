<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan_model;
use App\Http\Requests\StorePelangganRequest;
use App\Http\Requests\UpdatePelangganRequest;
use Illuminate\Http\Request;

class Pelanggan extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pelanggan = Pelanggan_model::select('kode_pelanggan', 'nama', 'alamat', 'telepon')->get();
        return view('pelanggan.index', compact('pelanggan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pelanggan = Pelanggan_model::select('kode_pelanggan', 'nama', 'alamat', 'telepon')->get();
        return view('pelanggan.create', compact('pelanggan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePelangganRequest $request)
    {
        Pelanggan_model::create([
            'kode_pelanggan' => strtoupper($request->kode_pelanggan),
            'nama' => $request->nama_pelanggan,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,
        ]);

        return redirect()->route('pelanggan.index');
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
    public function edit(string $kode_pelanggan)
    {
        $pelanggan = Pelanggan_model::where('kode_pelanggan', $kode_pelanggan)->firstOrFail();
        return view('pelanggan.edit', compact('pelanggan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePelangganRequest $request, string $kode_pelanggan)
    {
        Pelanggan_model::where('kode_pelanggan', $kode_pelanggan)->update([
            'kode_pelanggan' => strtoupper($request->kode_pelanggan),
            'nama' => $request->nama_pelanggan,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,
        ]);

        return redirect()->route('pelanggan.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $kode_pelanggan)
    {
        Pelanggan_model::where('kode_pelanggan', $kode_pelanggan)->delete();
        return redirect()->route('pelanggan.index');
    }
}
