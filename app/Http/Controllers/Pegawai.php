<?php

namespace App\Http\Controllers;

use App\Models\Pegawai_model;
use Illuminate\Http\Request;

class Pegawai extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Pegawai_model::all();
        return view('pegawai.index', compact('data'));
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
        
        $request->validate([
            'kode_pegawai' => 'required',
            'nama' => 'required',
            'username' => 'required',
            'password' => 'required',  
        ]);

        $request['password'] = bcrypt($request['password']);
        Pegawai_model::create($request->all());

        return redirect()->route('pegawai.index');
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
            'nama' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:pegawai,username,' . $id . ',kode_pegawai',
            'password' => 'nullable|string|min:6',
        ]);

        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = bcrypt($data['password']);
        }

        Pegawai_model::where('kode_pegawai', $id)->update($data);

        return redirect()->route('pegawai.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Pegawai_model::where('kode_pegawai', $id)->delete();
        return redirect()->route('pegawai.index');
    }
}
