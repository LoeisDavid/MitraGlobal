@extends('layouts.app')

@section('title', 'Tambah Nota Barang')
@push('select2css')
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush
@section('page-title', 'Form Nota Barang')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route("nota.index") }}">Nota</a></li>
        <li class="breadcrumb-item"><a href="{{ route("nota.show", $kode_nota) }}">Detail Nota</a></li>
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
              <form action="{{ route('nota_barang.store', $kode_nota) }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <!-- select -->
                            <div class="form-group">
                                <label for="selectBarang">Barang<span class="text-danger">*</span></label>
                                <select name="kode_barang"
                                        id="selectBarang"
                                        class="form-control @error('kode_barang') is-invalid
                                        @enderror"
                                        value="{{ old('kode_barang') }}"
                                        required>
                                </select>
                                @error('kode_barang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Merk</label>
                                <select id="filterMerk" class="form-control select2merk">
                                    <option value="">-- Semua Merk --</option>
                                    @foreach ($merk as $m)
                                        <option value="{{ $m->kode_merk }}">{{ $m->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Kategori</label>
                                <select id="filterKategori" class="form-control select2kategori">
                                    <option value="">-- Semua Kategori --</option>
                                    @foreach ($kategori as $k)
                                        <option value="{{ $k->kode_kategori }}">{{ $k->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="qty">Qty<span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('qty') is-invalid @enderror" value="{{ old('qty') }}" id="qty" name="qty" placeholder="Masukkan Jumlah Barang" required>
                            </div>
                        @error('qty')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="diskon">Diskon</label>
                                <input type="number" class="form-control @error('diskon') is-invalid
                                @enderror" value="{{ old('diskon') }}0" id="diskon" name="diskon" placeholder="Masukkan Diskon Barang">
                            @error('diskon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            </div>
                        </div>
                    </div>
                    
                <!-- /.card-body -->
                </div>
                <div class="card-footer d-flex justify-content-end">                
                  <a href="{{ route("nota.show", $kode_nota) }}" class="btn btn-secondary mr-2">Batal</a>
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
$(function () {

    // KATEGORI & MERK
    $('.select2merk').select2({
        theme: 'bootstrap4',
        placeholder: '-- Cari merk --',
        allowClear: true
    });

    $('.select2kategori').select2({
        theme: 'bootstrap4',
        placeholder: '-- Cari kategori --',
        allowClear: true
    });


        $('#selectBarang').select2({
        theme: 'bootstrap4',
        placeholder: '-- Cari barang --',
        allowClear: true,
        ajax: {
            url: "{{ route('nota_barang.ajaxBarang') }}",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    search: params.term || '',
                    page: params.page || 1,
                    kode_merk: $('#filterMerk').val(),
                    kode_kategori: $('#filterKategori').val()
                };
            },
            processResults: function (data, params) {
                params.page = params.page || 1;

                return {
                    results: data.results,
                    pagination: {
                        more: data.pagination.more
                    }
                };
            },
            cache: true
        }
    });

});
</script>
@endpush
