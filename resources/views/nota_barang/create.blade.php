@extends('layouts.app')

@section('title', 'Tambah Nota Barang')
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
                    <!-- select -->
                    <div class="form-group">
                        <label>Barang</label>
                        <select class="form-control" name="kode_barang">
                            @forelse ($barang as $item)
                                <option value="{{ $item->kode_barang }}">{{ $item->nama }} - Rp. {{ number_format($item->harga_jual, 0, ',', '.') }}</option>
                            @empty
                                <option disabled>Data Barang Tidak Tersedia</option>
                            @endforelse
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="qty">Qty</label>
                        <input type="number" class="form-control" id="qty" name="qty" placeholder="Masukkan Jumlah Barang">
                    </div>
                    <div class="form-group">
                        <label for="diskon">Diskon</label>
                        <input type="number" class="form-control" id="diskon" name="diskon" placeholder="Masukkan Diskon Barang"><span class="text-muted">*Dalam Persen (%)</span>
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