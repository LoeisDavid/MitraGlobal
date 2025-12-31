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
                    <label for="kode_pelanggan">Kode Pelanggan</label>
                    <input type="text" class="form-control" id="kode_pelanggan" name="kode_pelanggan" placeholder="Masukkan Kode Pelanggan" value="{{ $pelanggan->kode_pelanggan }}">
                  </div>
                  <div class="form-group">
                    <label for="nama_pelanggan">Nama Pelanggan</label>
                    <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan" placeholder="Masukkan Nama Pelanggan" required value="{{ $pelanggan->nama }}">
                  </div>
                  <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Masukkan Alamat Pelanggan" required value="{{ $pelanggan->alamat }}">
                  </div>
                  <div class="form-group">
                    <label for="telepon">Telepon</label>
                    <input type="text" class="form-control" id="telepon" name="telepon" placeholder="Masukkan Telepon Pelanggan" required value="{{ $pelanggan->telepon }}">
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