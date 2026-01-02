<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNotaRequest;
use App\Http\Requests\UpdateNotaRequest;
use App\Models\Nota_model;
use App\Models\Pelanggan_model;
use App\Models\Pegawai_model;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class Nota extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $nota = Nota_model::with(['pelanggan', 'pegawai'])->get();
        return view('nota.index', compact('nota'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pelanggan = Pelanggan_model::select('kode_pelanggan', 'nama')->get();
        $pegawai = Pegawai_model::select('kode_pegawai', 'nama')->get();
        return view('nota.create', compact('pelanggan', 'pegawai'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNotaRequest $request)
    {
        $validated = $request->validated();
        Nota_model::create($validated);
        return redirect()->route('nota.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(String $no_nota)
    {
        $nota = Nota_model::with(['pelanggan', 'pegawai'])->findOrFail($no_nota);
        return view('nota.show', compact('nota'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $no_nota)
    {
        $nota = Nota_model::with(['pelanggan', 'pegawai'])->findOrFail($no_nota);
        $pelanggan = Pelanggan_model::select('kode_pelanggan', 'nama')->get();
        $pegawai = Pegawai_model::select('kode_pegawai', 'nama')->get();
        return view('nota.edit', compact('nota', 'pelanggan', 'pegawai'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNotaRequest $request, string $no_nota)
    {
        $validated = $request->validated();
        Nota_model::where('no_nota', $no_nota)->update($validated);
        return redirect()->route('nota.index');
    }

    public function finalize(string $no_nota)
    {
        Nota_model::where('no_nota', $no_nota)->update(['draft' => false]);
        return redirect()->route('nota.index');
    }

    public function preview(string $no_nota)
    {
        $nota = Nota_model::with(['pelanggan', 'pegawai'])->findOrFail($no_nota);
        $pdf = Pdf::loadView('nota.pdf', compact('nota'));
        return $pdf->stream('Nota#'.$no_nota.'.pdf');
    }

    public function download(string $no_nota)
    {
        $nota = Nota_model::with(['pelanggan', 'pegawai'])->findOrFail($no_nota);
        $pdf = Pdf::loadView('nota.pdf', compact('nota'));
        return $pdf->download('Nota#'.$no_nota.'.pdf');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $no_nota)
    {
        Nota_model::where('no_nota', $no_nota)->delete();
        return redirect()->route('nota.index');
    }
}
