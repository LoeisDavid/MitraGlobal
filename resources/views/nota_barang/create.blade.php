@extends('layouts.app')

@section('title', 'Tambah Nota Barang')

@push('select2css')
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

            <form action="{{ route('nota_barang.store', $kode_nota) }}" method="POST">
                @csrf

                <div class="card-body">
                    <div class="row">

                        {{-- FILTER MERK --}}
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

                        {{-- FILTER KATEGORI --}}
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

                        {{-- SELECT BARANG --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="selectBarang">
                                    Barang<span class="text-danger">*</span>
                                </label>

                                <select name="kode_barang"
                                        id="selectBarang"
                                        class="form-control @error('kode_barang') is-invalid @enderror"
                                        required>
                                </select>

                                @error('kode_barang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- DETAIL BARANG --}}
                        <div class="col-md-12">
                            <div id="barangDetail" class="card bg-light d-none">
                                <div class="card-body p-3">
                                    <h5 class="mb-3">Detail Barang</h5>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Harga Beli</label>
                                            <input type="text"
                                                   id="detailHargaBeli"
                                                   class="form-control"
                                                   readonly>
                                        </div>

                                        <div class="col-md-4">
                                            <label>Diskon (%)</label>
                                            <input type="text"
                                                   id="detailDiskon"
                                                   class="form-control"
                                                   readonly>
                                        </div>

                                        <div class="col-md-4">
                                            <label>Modal</label>
                                            <input type="text"
                                                   id="detailModal"
                                                   class="form-control"
                                                   readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- QTY --}}
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="qty">
                                    Qty<span class="text-danger">*</span>
                                </label>

                                <input type="number"
                                       class="form-control @error('qty') is-invalid @enderror"
                                       value="{{ old('qty') }}"
                                       id="qty"
                                       name="qty"
                                       placeholder="Masukkan Jumlah Barang"
                                       required>

                                @error('qty')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- HARGA INPUT --}}
<div class="col-md-12">
    <div class="form-group">
        <label for="harga">
            Harga<span class="text-danger">*</span>
        </label>

        <input type="number"
               class="form-control @error('harga') is-invalid @enderror"
               value="{{ old('harga') }}"
               id="harga"
               name="harga"
               placeholder="Masukkan Harga Barang"
               required>

        @error('harga')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <span class="text-muted">
        Harga jual / harga transaksi
    </span>
    </div>
</div>

                        {{-- DISKON INPUT --}}
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="diskon">Diskon</label>

                                <input type="number"
                                       class="form-control @error('diskon') is-invalid @enderror"
                                       value="{{ old('diskon') ?? 0 }}"
                                       id="diskon"
                                       name="diskon"
                                       placeholder="Masukkan Diskon Barang">

                                @error('diskon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <span class="text-muted">
                                Diskon dalam persen (%)
                            </span>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card-footer d-flex justify-content-end">
                    <a href="{{ route("nota.show", $kode_nota) }}"
                       class="btn btn-secondary mr-2">
                       Batal
                    </a>

                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('select2js')
<script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>

<script>
$(document).ready(function () {

    // SELECT2 MERK
    $('#filterMerk').select2({
        theme: 'bootstrap4',
        placeholder: '-- Cari merk --',
        allowClear: true
    });

    // SELECT2 KATEGORI
    $('#filterKategori').select2({
        theme: 'bootstrap4',
        placeholder: '-- Cari kategori --',
        allowClear: true
    });

    // SELECT2 BARANG
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
            processResults: function (data) {
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

    // RESET BARANG JIKA FILTER BERUBAH
    $('#filterMerk, #filterKategori').on('change', function () {
        $('#selectBarang').val(null).trigger('change');
        $('#barangDetail').addClass('d-none');
    });

    // TAMPILKAN DETAIL SAAT BARANG DIPILIH
    $('#selectBarang').on('select2:select', function (e) {

        const data = e.params.data;

        if (!data.harga_beli) {
            console.warn('harga_beli tidak ada dari AJAX');
            return;
        }

        const hargaBeli = parseFloat(data.harga_beli);
        const diskon = parseFloat(data.diskon ?? 0);
        const modal = hargaBeli - (hargaBeli * (diskon / 100));

        $('#barangDetail').removeClass('d-none');

        $('#detailHargaBeli').val(formatRupiah(hargaBeli));
        $('#detailDiskon').val(diskon + ' %');
        $('#detailModal').val(formatRupiah(modal));
    });

});

// FORMAT RUPIAH
function formatRupiah(angka) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(angka);
}
</script>
@endpush