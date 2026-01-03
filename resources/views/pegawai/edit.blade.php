@extends('layouts.app')

@section('title', 'Ubah Pegawai')
@section('page-title', 'Form Pegawai')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route("pegawai.index") }}">Pegawai</a></li>
        <li class="breadcrumb-item active">Ubah Pegawai</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Ubah Pegawai</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{ route('pegawai.update', $pegawai->kode_pegawai) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                  <div class="form-group">
                    <label for="kode_pegawai">Kode Pegawai</label>
                    <input type="text" class="form-control" id="kode_pegawai" name="kode_pegawai" placeholder="Masukkan Kode Pegawai" value="{{ $pegawai->kode_pegawai }}">
                  </div>
                  <div class="form-group">
                    <label for="nama_pegawai">Nama Pegawai</label>
                    <input type="text" class="form-control" id="nama_pegawai" name="nama" placeholder="Masukkan Nama Pegawai" required value="{{ $pegawai->nama }}">
                  </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan Username" required value="{{ $pegawai->username }}">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan Password">
                        <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password.</small>
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