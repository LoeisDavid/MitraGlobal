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

public function index(Request $request)
{
    try {
        $keyword = $request->keyword;

        $query = Pelanggan_model::select(
            'kode_pelanggan',
            'nama',
            'alamat',
            'telepon'
        );

        // SEARCH (dikurung biar orWhere tidak liar)
        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('kode_pelanggan', 'like', "%{$keyword}%")
                  ->orWhere('nama', 'like', "%{$keyword}%")
                  ->orWhere('alamat', 'like', "%{$keyword}%")
                  ->orWhere('telepon', 'like', "%{$keyword}%");
            });
        }

        // URUT A–Z + PAGINATION 10
        $pelanggan = $query
            ->orderBy('nama', 'asc')
            ->paginate(10)
            ->appends($request->query());

        return view('pelanggan.index', compact('pelanggan', 'keyword'));

    } catch (\Throwable $e) {

        Log::error('Gagal mengambil data pelanggan', [
            'error' => $e->getMessage()
        ]);

        return back()->withErrors([
            'error' => 'Gagal mengambil data pelanggan.'
        ]);
    }
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
    $validated = $request->validated();
    try {
        Pelanggan_model::create($validated);

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
    $validated = $request->validated();
    try {
        $updated = Pelanggan_model::where('kode_pelanggan', $kode_pelanggan)
            ->update($validated);

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
