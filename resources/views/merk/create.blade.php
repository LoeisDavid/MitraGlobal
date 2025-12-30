@extends('layouts.app')

@section('title', 'Tambah Merk')
@section('page-title', 'Form Merk')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route("merk.index") }}">Merk</a></li>
        <li class="breadcrumb-item active">Tambah Merk</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Tambah Merk</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{ route("merk.store") }}" method="POST">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="kode_Merk">Kode Merk</label>
                    <input type="text" class="form-control" name='kode_merk' id="kode_Merk" placeholder="Masukkan Kode Merk">
                  </div>
                  <div class="form-group">
                    <label for="nama_Merk">Nama Merk</label>
                    <input type="text" class="form-control" name='nama' id="nama_Merk" placeholder="Masukkan Nama Merk">
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer d-flex justify-content-end">                
                  <a href="{{ route("merk.index") }}" class="btn btn-secondary mr-2">Batal</a>
                  <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
              </form>
            </div>
        </div>
    </div>
@endsection