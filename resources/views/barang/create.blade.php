@extends('layouts.app')

@section('title', 'Tambah Barang')
@section('page-title', 'Form Barang')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route("barang.index") }}">Barang</a></li>
        <li class="breadcrumb-item active">Tambah Barang</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Tambah Barang</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{ route('barang.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <!-- kode barang -->
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="kode_barang">Kode Barang</label>
                                <input type="text" class="form-control" id="kode_barang" name="kode_barang" placeholder="Masukkan Kode Barang">
                            </div>
                        </div>
                        <!-- end kode barang -->

                        <!-- nama barang -->
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="nama_barang">Nama Barang</label>
                                <input type="text" class="form-control" id="nama_barang" name="nama_barang" placeholder="Masukkan Nama Barang">
                            </div>
                        </div>
                        <!-- end nama barang -->

                        <!-- kategori -->
                        <div class="col-sm-6">
                            <!-- select -->
                            <div class="form-group">
                                <label>Kategori</label>
                                <select class="form-control">
                                <option>option 1</option>
                                <option>option 2</option>
                                </select>
                            </div>
                        </div>
                        <!-- end kategori -->

                        <!-- merek -->
                        <div class="col-sm-6">
                            <!-- select -->
                            <div class="form-group">
                                <label>Merek</label>
                                <select class="form-control">
                                <option>option 1</option>
                                <option>option 2</option>
                                </select>
                            </div>
                        </div>
                        <!-- end merek -->

                        <!-- harga jual -->
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="harga_jual">Harga Jual</label>
                                <input type="number" class="form-control" id="harga_jual" name="harga_jual" placeholder="Masukkan Harga Jual">
                            </div>
                        </div>
                        <!-- end harga jual -->

                        <!-- stok -->
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="stok">Stok</label>
                                <input type="number" class="form-control" id="stok" name="stok" placeholder="Masukkan Stok">
                            </div>
                        </div>
                        <!-- end stok -->
                         
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer d-flex justify-content-end">                
                  <a href="{{ route("barang.index") }}" class="btn btn-secondary mr-2">Batal</a>
                  <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
              </form>
            </div>
        </div>
    </div>
@endsection