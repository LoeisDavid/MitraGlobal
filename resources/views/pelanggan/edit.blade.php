@extends('layouts.app')

@section('title', 'Ubah Pelanggan')
@section('page-title', 'Form Pelanggan')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route("pelanggan.index") }}">Pelanggan</a></li>
        <li class="breadcrumb-item active">Ubah Pelanggan</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Ubah Pelanggan</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{ route('pelanggan.update', $pelanggan->kode_pelanggan) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                  <div class="form-group">
                    <label for="kode_pelanggan">Kode Pelanggan<span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('kode_pelanggan') is-invalid @enderror"
                    id="kode_pelanggan"
                    name="kode_pelanggan"
                    placeholder="Masukkan Kode Pelanggan"
                    value="{{ old("kode_pelanggan", $pelanggan->kode_pelanggan) }}">
                    @error('kode_pelanggan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="nama_pelanggan">Nama Pelanggan<span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror"
                    id="nama_pelanggan"
                    name="nama"
                    placeholder="Masukkan Nama Pelanggan"
                    required
                    value="{{ old("nama", $pelanggan->nama) }}">
                    @error('nama_pelanggan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="alamat">Alamat<span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('alamat') is-invalid @enderror"
                    id="alamat"
                    name="alamat"
                    placeholder="Masukkan Alamat Pelanggan"
                    required
                    value="{{ old("alamat", $pelanggan->alamat) }}">
                  </div>
                  <div class="form-group">
                    <label for="telepon">Telepon<span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('telepon') is-invalid @enderror"
                    id="telepon"
                    name="telepon"
                    placeholder="Masukkan Telepon Pelanggan"
                    required value="{{ old("telepon", $pelanggan->telepon) }}">
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer d-flex justify-content-end">                
                  <a href="{{ route("pelanggan.index") }}" class="btn btn-secondary mr-2">Batal</a>
                  <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
              </form>
            </div>
        </div>
    </div>
@endsection