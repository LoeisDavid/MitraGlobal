@extends('layouts.app')

@section('title', 'Ubah Barang')
@section('page-title', 'Form Barang')
@push('select2css')
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush
@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route("barang.index") }}">Barang</a></li>
        <li class="breadcrumb-item active">Ubah Barang</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Ubah Barang</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{ route('barang.update', $barang->kode_barang) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <!-- kode barang -->
                        <div class="col-sm-12">
                            <div class="form-group">
                                <!-- <label for="kode_barang">Kode Barang</label> -->
                                <input type="text" class="form-control" value="{{ $barang->kode_barang }}" id="kode_barang" name="kode_barang" placeholder="Masukkan Kode Barang" disabled>
                            </div>
                        </div>
                        <!-- end kode barang -->

                        <!-- nama barang -->
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="nama_barang">Nama Barang<span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama') is-invalid
                                @enderror" value="{{ old('nama', $barang->nama) }}" id="nama_barang" name="nama" placeholder="Masukkan Nama Barang">
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <!-- end nama barang -->

                        <!-- kategori -->
                        <div class="col-sm-6">
                            <!-- select -->
                            <div class="form-group">
                                <label>Kategori<span class="text-danger">*</span></label>
                                <select class="form-control @error('kategori_kode_kategori') is-invalid
                                @enderror" name="kategori_kode_kategori" id="select2kategori">
                                @forelse ($kategoris as $kategori)
                                    <option value="{{ $kategori->kode_kategori }}" {{ old('kategori_kode_kategori', $barang->kategori_kode_kategori) == $kategori->kode_kategori ? 'selected' : '' }}>{{ $kategori->nama }}</option>
                                @empty
                                    <option>Data Kategori tidak tersedia</option>
                                @endforelse
                                </select>
                                @error('kategori_kode_kategori')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <!-- end kategori -->

                        <!-- merek -->
                        <div class="col-sm-6">
                            <!-- select -->
                            <div class="form-group">
                                <label>Merek<span class="text-danger">*</span></label>
                                <select class="form-control @error('merk_kode_merk') is-invalid
                                @enderror" name="merk_kode_merk" id="select2merk">
                                @forelse ($merks as $merk)
                                    <option value="{{ $merk->kode_merk }}" {{ old('merk_kode_merk', $barang->merk_kode_merk) == $merk->kode_merk ? 'selected' : '' }}>{{ $merk->nama }}</option>
                                @empty
                                    <option>Data Merek tidak tersedia</option>
                                @endforelse
                                </select>
                            </div>
                        </div>
                        <!-- end merek -->

                        <!-- harga jual -->
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="harga_beli">Harga Beli<span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('harga_beli') is-invalid
                                @enderror" value="{{ old('harga_beli', number_format($barang->harga_beli, 0, ',', '.')) }}" id="harga_beli" name="harga_beli" placeholder="Masukkan Harga Jual">
                                @error('harga_beli')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <!-- end harga jual -->

                        <!-- diskon -->
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="diskon">Diskon<span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('diskon') is-invalid
                                @enderror" value="{{ old('diskon', number_format($barang->diskon, 0, ',', '.')) }}" id="diskon" name="diskon" placeholder="Masukkan Diskon">
                                @error('diskon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <span class="text-muted">Diskon dalam persen (%)</span>
                            </div>
                        </div>
                        <!-- diskon -->

                        <!-- stok -->
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="stok">Stok<span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('stok') is-invalid
                                @enderror" value="{{ old('stok', $barang->stok) }}" id="stok" name="stok" placeholder="Masukkan Stok">
                                @error('stok')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
@push('select2js')
    <!-- Select2 JS -->
    <script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2 Elements
            $('#select2kategori').select2({
                theme: 'bootstrap4',
                placeholder: "-- Pilih Kategori --",
                allowClear: true
            });
            $('#select2merk').select2({
                theme: 'bootstrap4',
                placeholder: "-- Pilih Merk --",
                allowClear: true
            });
        });
    </script>
@endpush