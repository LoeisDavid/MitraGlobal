<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNotaRequest;
use App\Http\Requests\UpdateNotaRequest;
use App\Models\Nota_model;
use App\Models\Pelanggan_model;
use App\Models\Pegawai_model;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\NotaJualDetil_model;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class Nota extends Controller
{
    /**
     * Display a listing of the resource.
     */

public function index(Request $request)
{
    try {
        $query = Nota_model::with(['pelanggan', 'pegawai']);

        // SEARCH KEYWORD
        if ($request->filled('keyword')) {
            $query->where(function ($q) use ($request) {
                $q->where('no_nota', 'like', '%' . $request->keyword . '%')
                  ->orWhereHas('pelanggan', function ($q2) use ($request) {
                      $q2->where('nama', 'like', '%' . $request->keyword . '%');
                  })
                  ->orWhereHas('pegawai', function ($q3) use ($request) {
                      $q3->where('nama', 'like', '%' . $request->keyword . '%');
                  });
            });
        }

        // FILTER STATUS (BOOLEAN)
        if ($request->filled('status')) {
            if ($request->status === 'draft') {
                $query->where('draft', true);
            } elseif ($request->status === 'final') {
                $query->where('draft', false);
            }
        }

        // FILTER BULAN
        if ($request->filled('bulan')) {
            $query->where('tanggal', '>=', Carbon::now()->subMonths((int) $request->bulan));
        }

        // URUT + PAGINATE
        $nota = $query
            ->orderBy('tanggal', 'desc')
            ->paginate(10)
            ->appends($request->query());

        return view('nota.index', compact('nota', 'request'));

    } catch (\Throwable $e) {

        // LOG ERROR (WAJIB, jangan cuma return kosong)
        Log::error('Gagal load data nota', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);

        // fallback ke halaman dengan pesan error
        return redirect()
            ->back()
            ->with('error', 'Terjadi kesalahan saat memuat data nota.');
    }
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
    try {
        $validated = $request->validated();
        $validated['draft'] = true;

        $validated['no_nota'] = $this->generateNoNota($validated['tanggal']);

        Nota_model::create($validated);

        return redirect()
            ->route('nota.show', $validated['no_nota'])
            ->with('success', 'Nota berhasil dibuat');

    } catch (QueryException $e) {
        Log::error('DB Error saat simpan nota', ['error' => $e->getMessage()]);

        return back()->withInput()->with(
            'error',
            'Gagal menyimpan nota (masalah database)'
        );

    } catch (\Throwable $e) {
        Log::error('Error umum saat simpan nota', ['error' => $e->getMessage()]);

        return back()->withInput()->with(
            'error',
            'Terjadi kesalahan tak terduga saat menyimpan nota'
        );
    }
}



    /**
     * Display the specified resource.
     */
    public function show(string $no_nota)
{
    try {
        $nota = Nota_model::with(['pelanggan', 'pegawai'])->findOrFail($no_nota);
        $detils = NotaJualDetil_model::with(['barang'])
            ->where('notaJual_no_nota', $no_nota)
            ->get();

        $subtotal = 0;
        $totalDiskon = 0;

        foreach ($detils as $detil) {
            if (!$detil->barang) {
                throw new \Exception('Barang pada nota tidak lengkap');
            }

            $rowSubtotal = $detil->harga * $detil->jumlah;
            $rowDiskon   = $rowSubtotal * ($detil->diskon / 100);

            $subtotal += $rowSubtotal;
            $totalDiskon += $rowDiskon;
        }

        $total = $subtotal - $totalDiskon;

        return view('nota.show', compact(
            'nota', 'detils', 'subtotal', 'totalDiskon', 'total'
        ));

    } catch (NotFoundHttpException $e) {
        return redirect()
            ->route('nota.index')
            ->with('error', 'Nota tidak ditemukan');

    } catch (\Throwable $e) {
        Log::error('Error saat tampilkan nota', ['error' => $e->getMessage()]);

        return redirect()
            ->route('nota.index')
            ->with('error', 'Gagal menampilkan detail nota');
    }
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
    DB::beginTransaction();

    try {
        $validated = $request->validated();

        $oldNoNota = $no_nota;
        $newNoNota = $this->generateNoNota($validated['tanggal']);

        // ambil detil kalau ada
        $detils = NotaJualDetil_model::where('notajual_no_nota', $oldNoNota)->get();

        // kalau ada detil, hapus dulu
        if ($detils->isNotEmpty()) {
            NotaJualDetil_model::where('notajual_no_nota', $oldNoNota)->delete();
        }

        // update parent (sekarang FK sudah aman)
        $validated['no_nota'] = $newNoNota;
        Nota_model::where('no_nota', $oldNoNota)->update($validated);

        // kalau sebelumnya ada detil, masukin lagi
        if ($detils->isNotEmpty()) {
            $newDetils = $detils->map(function ($item) use ($newNoNota) {
                return [
                    'notajual_no_nota' => $newNoNota,
                    'barang_kode_barang' => $item->barang_kode_barang,
                    'jumlah' => $item->jumlah,
                    'harga' => $item->harga,
                    'diskon' => $item->diskon,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            })->toArray();

            NotaJualDetil_model::insert($newDetils);
        }

        DB::commit();

        return redirect()
            ->route('nota.index')
            ->with('success', 'Data nota berhasil diperbarui.');

    } catch (\Throwable $e) {
        DB::rollBack();

        return back()->withErrors([
            'error' => 'Gagal update nota: ' . $e->getMessage()
        ]);
    }
}





    public function finalize(string $no_nota)
    {
        Nota_model::where('no_nota', $no_nota)->update(['draft' => false]);
        return redirect()->route('nota.index');
    }

    public function preview(string $no_nota)
{
    try {
        $nota = Nota_model::with(['pelanggan', 'pegawai'])->findOrFail($no_nota);
        $detils = NotaJualDetil_model::with(['barang'])
            ->where('notaJual_no_nota', $no_nota)
            ->get();

        $subtotal = 0;
        $totalDiskon = 0;

        foreach ($detils as $detil) {
            $subtotal += $detil->harga * $detil->jumlah;
            $totalDiskon += ($detil->harga * $detil->jumlah) * ($detil->diskon / 100);
        }

        $total = $subtotal - $totalDiskon;

        $pdf = Pdf::loadView('nota.pdf', compact(
            'nota', 'detils', 'subtotal', 'totalDiskon', 'total'
        ));

        return $pdf->stream('Nota#'.$no_nota.'.pdf');

    } catch (\Throwable $e) {
        Log::error('PDF Error', ['error' => $e->getMessage()]);

        return redirect()
            ->route('nota.index')
            ->with('error', 'Gagal membuat preview PDF');
    }
}


    public function download(string $no_nota)
    {
        $nota = Nota_model::with(['pelanggan', 'pegawai'])->findOrFail($no_nota);
        $detils = NotaJualDetil_model::with(['barang'])->where('notaJual_no_nota', $no_nota)->get();

        $subtotal = 0;
        $totalDiskon = 0;

        foreach ($detils as $detil) {
            $rowSubtotal = $detil->harga * $detil->jumlah;
            $rowDiskon   = $rowSubtotal * ($detil->diskon / 100);

            $subtotal += $rowSubtotal;
            $totalDiskon += $rowDiskon;
        }
        $total = $subtotal - $totalDiskon;
        $pdf = Pdf::loadView('nota.pdf', compact('nota', 'detils', 'subtotal', 'totalDiskon', 'total'));
        return $pdf->download('Nota#'.$no_nota.'.pdf');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $no_nota)
{
    try {
        Nota_model::where('no_nota', $no_nota)->delete();

        return redirect()
            ->route('nota.index')
            ->with('success', 'Nota berhasil dihapus');

    } catch (QueryException $e) {
        Log::error('Delete gagal', ['error' => $e->getMessage()]);

        return redirect()
            ->route('nota.index')
            ->with('error', 'Nota gagal dihapus (masih digunakan)');
    }
}

}
