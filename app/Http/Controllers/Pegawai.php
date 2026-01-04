<?php

namespace App\Http\Controllers;

use App\Models\Pegawai_model;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;


class Pegawai extends Controller
{
    /**
     * Display a listing of the resource.
     */

public function index(Request $request)
{
    try {
        $keyword = $request->search;

        $query = Pegawai_model::select('kode_pegawai', 'nama', 'username');

        // SEARCH (sudah benar, kita pertahankan)
        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('nama', 'like', "%{$keyword}%")
                  ->orWhere('username', 'like', "%{$keyword}%")
                  ->orWhere('kode_pegawai', 'like', "%{$keyword}%");
            });
        }

        // URUTKAN A–Z + PAGINATION 10
        $data = $query
            ->orderBy('nama', 'asc')
            ->paginate(10)
            ->appends($request->query());

        return view('pegawai.index', compact('data', 'keyword'));

    } catch (\Throwable $e) {

        Log::error('Gagal mengambil data pegawai', [
            'error' => $e->getMessage()
        ]);

        return back()->withErrors([
            'error' => 'Gagal mengambil data pegawai.'
        ]);
    }
}



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pegawai.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'kode_pegawai' => 'required',
        'nama'         => 'required',
        'username'     => 'required',
        'password'     => 'required',
    ]);

    try {
        $validated['password'] = bcrypt($validated['password']);

        Pegawai_model::create($validated);

        return redirect()
            ->route('pegawai.index')
            ->with('success', 'Pegawai berhasil ditambahkan');

    } catch (QueryException $e) {
        Log::error('DB Error tambah pegawai', ['error' => $e->getMessage()]);

        return back()->withInput()->with(
            'error',
            'Gagal menyimpan data pegawai (data duplikat atau database error)'
        );

    } catch (\Throwable $e) {
        Log::error('Error tambah pegawai', ['error' => $e->getMessage()]);

        return back()->withInput()->with(
            'error',
            'Terjadi kesalahan saat menyimpan data pegawai'
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
        $pegawai = Pegawai_model::findOrFail($id);
        return view('pegawai.edit', compact('pegawai'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    $data = $request->validate([
        'nama'     => 'required|string|max:100',
        'username' => 'required|string|max:50|unique:pegawai,username,' . $id . ',kode_pegawai',
        'password' => 'nullable|string|min:6',
    ]);

    try {
        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $updated = Pegawai_model::where('kode_pegawai', $id)->update($data);

        if ($updated === 0) {
            throw new \Exception('Pegawai tidak ditemukan');
        }

        return redirect()
            ->route('pegawai.index')
            ->with('success', 'Data pegawai berhasil diperbarui');

    } catch (QueryException $e) {
        Log::error('DB Error update pegawai', ['error' => $e->getMessage()]);

        return back()->withInput()->with(
            'error',
            'Gagal memperbarui data pegawai (database error)'
        );

    } catch (\Throwable $e) {
        Log::error('Error update pegawai', ['error' => $e->getMessage()]);

        return back()->withInput()->with(
            'error',
            $e->getMessage() ?: 'Terjadi kesalahan saat update pegawai'
        );
    }
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
{
    try {
        $deleted = Pegawai_model::where('kode_pegawai', $id)->delete();

        if ($deleted === 0) {
            throw new \Exception('Pegawai tidak ditemukan');
        }

        return redirect()
            ->route('pegawai.index')
            ->with('success', 'Pegawai berhasil dihapus');

    } catch (QueryException $e) {
        Log::error('DB Error hapus pegawai', ['error' => $e->getMessage()]);

        return redirect()
            ->route('pegawai.index')
            ->with('error', 'Pegawai tidak bisa dihapus (masih digunakan)');

    } catch (\Throwable $e) {
        Log::error('Error hapus pegawai', ['error' => $e->getMessage()]);

        return redirect()
            ->route('pegawai.index')
            ->with('error', 'Gagal menghapus pegawai');
    }
}

}
