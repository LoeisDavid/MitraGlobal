@extends('layouts.app')

@section('title', 'Tambah Kategori')
@section('page-title', 'Form Kategori')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route("kategori.index") }}">Kategori</a></li>
        <li class="breadcrumb-item active">Tambah Kategori</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Tambah Kategori</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{ route('kategori.store') }}" method="POST">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="kode_kategori">Kode Kategori</label>
                    <input type="text" class="form-control" id="kode_kategori" name="kode_kategori" placeholder="Masukkan Kode Kategori">
                  </div>
                  <div class="form-group">
                    <label for="nama_kategori">Nama Kategori</label>
                    <input type="text" class="form-control" id="nama_kategori" name="nama" placeholder="Masukkan Nama Kategori" required>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer d-flex justify-content-end">                
                  <a href="{{ route("kategori.index") }}" class="btn btn-secondary mr-2">Batal</a>
                  <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
              </form>
            </div>
        </div>
    </div>
@endsection