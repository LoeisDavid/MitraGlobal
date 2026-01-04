@extends('layouts.app')

@section('title', 'Tambah Pegawai')
@section('page-title', 'Form Pegawai')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route("pegawai.index") }}">Pegawai</a></li>
        <li class="breadcrumb-item active">Tambah Pegawai</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Tambah Pegawai</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{ route('pegawai.store') }}" method="POST">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="kode_pegawai">Kode Pegawai<span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('kode_pegawai') is-invalid @enderror" id="kode_pegawai" name="kode_pegawai" placeholder="Masukkan Kode Pegawai" value="{{ old('kode_pegawai') }}">
                    @error('kode_pegawai')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="nama_pegawai">Nama Pegawai<span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama_pegawai" name="nama" placeholder="Masukkan Nama Pegawai" required value="{{ old('nama') }}">
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                    <div class="form-group">
                        <label for="username">Username<span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" placeholder="Masukkan Username" required value="{{ old('username') }}">
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Password<span class="text-danger">*</span></label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Masukkan Password" required value="{{ old('password') }}">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer d-flex justify-content-end">                
                  <a href="{{ route("pegawai.index") }}" class="btn btn-secondary mr-2">Batal</a>
                  <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
              </form>
            </div>
        </div>
    </div>
@endsection