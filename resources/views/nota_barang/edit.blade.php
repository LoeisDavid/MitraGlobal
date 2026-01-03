@extends('layouts.app')

@section('title', 'Ubah Nota Barang')
@push('select2css')
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush
@section('page-title', 'Form Nota Barang')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route("nota.index") }}">Nota</a></li>
        <li class="breadcrumb-item"><a href="{{ route("nota.show", $no_nota) }}">Detail Nota</a></li>
        <li class="breadcrumb-item active">Ubah Nota Barang</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Ubah Nota Barang</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{ route('nota_barang.update', $detil->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <!-- select -->
                    <div class="form-group">
                        <label for="selectBarang">Barang</label>
                        <select name="kode_barang"
                                id="selectBarang"
                                class="form-control selectBarang"
                                required>

                            <option value="">-- Pilih Barang --</option>

                            @foreach ($barang as $row)
                                <option value="{{ $row->kode_barang }}" {{ $detil->barang->kode_barang == $row->kode_barang ? 'selected' : '' }}>
                                    {{ $row->nama }} - Rp. {{ number_format($row->harga_jual, 0, ',', '.') }}
                                </option>
                            @endforeach

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="qty">Qty</label>
                        <input type="number" class="form-control" value="{{ $detil->jumlah }}" id="qty" name="qty" placeholder="Masukkan Jumlah Barang">
                    </div>
                    <div class="form-group">
                        <label for="diskon">Diskon</label>
                        <input type="number" class="form-control" value="{{ $detil->diskon }}" id="diskon" name="diskon" placeholder="Masukkan Diskon Barang">
                    </div>
                <!-- /.card-body -->
                </div>
                <div class="card-footer d-flex justify-content-end">                
                  <a href="{{ route("nota.show", $no_nota) }}" class="btn btn-secondary mr-2">Batal</a>
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
            $('.selectBarang').select2({
                theme: 'bootstrap4',
                placeholder: '-- Pilih Barang --',
            });
        });
    </script>
@endpush