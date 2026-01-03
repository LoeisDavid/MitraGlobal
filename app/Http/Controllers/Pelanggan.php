<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan_model;
use App\Http\Requests\StorePelangganRequest;
use App\Http\Requests\UpdatePelangganRequest;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;


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
    try {
        Pelanggan_model::create([
            'kode_pelanggan' => strtoupper($request->kode_pelanggan),
            'nama'           => $request->nama_pelanggan,
            'alamat'         => $request->alamat,
            'telepon'        => $request->telepon,
        ]);

        return redirect()
            ->route('pelanggan.index')
            ->with('success', 'Pelanggan berhasil ditambahkan');

    } catch (QueryException $e) {
        Log::error('DB Error tambah pelanggan', ['error' => $e->getMessage()]);

        return back()->withInput()->with(
            'error',
            'Gagal menyimpan pelanggan (kode sudah digunakan atau database error)'
        );

    } catch (\Throwable $e) {
        Log::error('Error tambah pelanggan', ['error' => $e->getMessage()]);

        return back()->withInput()->with(
            'error',
            'Terjadi kesalahan saat menyimpan data pelanggan'
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
    try {
        $updated = Pelanggan_model::where('kode_pelanggan', $kode_pelanggan)
            ->update([
                'kode_pelanggan' => strtoupper($request->kode_pelanggan),
                'nama'           => $request->nama_pelanggan,
                'alamat'         => $request->alamat,
                'telepon'        => $request->telepon,
            ]);

        if ($updated === 0) {
            throw new \Exception('Pelanggan tidak ditemukan');
        }

        return redirect()
            ->route('pelanggan.index')
            ->with('success', 'Data pelanggan berhasil diperbarui');

    } catch (QueryException $e) {
        Log::error('DB Error update pelanggan', ['error' => $e->getMessage()]);

        return back()->withInput()->with(
            'error',
            'Gagal memperbarui pelanggan (kode duplikat atau database error)'
        );

    } catch (\Throwable $e) {
        Log::error('Error update pelanggan', ['error' => $e->getMessage()]);

        return back()->withInput()->with(
            'error',
            $e->getMessage() ?: 'Terjadi kesalahan saat update pelanggan'
        );
    }
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $kode_pelanggan)
{
    try {
        $deleted = Pelanggan_model::where('kode_pelanggan', $kode_pelanggan)->delete();

        if ($deleted === 0) {
            throw new \Exception('Pelanggan tidak ditemukan');
        }

        return redirect()
            ->route('pelanggan.index')
            ->with('success', 'Pelanggan berhasil dihapus');

    } catch (QueryException $e) {
        Log::error('DB Error hapus pelanggan', ['error' => $e->getMessage()]);

        return redirect()
            ->route('pelanggan.index')
            ->with('error', 'Pelanggan tidak bisa dihapus (masih digunakan)');

    } catch (\Throwable $e) {
        Log::error('Error hapus pelanggan', ['error' => $e->getMessage()]);

        return redirect()
            ->route('pelanggan.index')
            ->with('error', 'Gagal menghapus pelanggan');
    }
}

}
