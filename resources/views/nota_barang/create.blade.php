@extends('layouts.app')

@section('title', 'Tambah Nota Barang')
@section('page-title', 'Form Nota Barang')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route("nota.index") }}">Nota</a></li>
        <li class="breadcrumb-item"><a href="{{ route("nota.show") }}">Detail Nota</a></li>
        <li class="breadcrumb-item active">Tambah Nota Barang</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Tambah Nota Barang</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{ route('nota_barang.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <!-- select -->
                    <div class="form-group">
                        <label>Barang</label>
                        <select class="form-control">
                        <option>option 1</option>
                        <option>option 2</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="qty">Qty</label>
                        <input type="number" class="form-control" id="qty" name="qty" placeholder="Masukkan Jumlah Barang">
                    </div>
                    <div class="form-group">
                        <label for="diskon">Diskon</label>
                        <input type="number" class="form-control" id="diskon" name="diskon" placeholder="Masukkan Diskon Barang">
                    </div>
                <!-- /.card-body -->
                </div>
                <div class="card-footer d-flex justify-content-end">                
                  <a href="{{ route("nota.show") }}" class="btn btn-secondary mr-2">Batal</a>
                  <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
              </form>
            </div>
        </div>
    </div>
@endsection