@extends('layouts.app')

@section('title', 'Tambah Nota')
@section('page-title', 'Form Nota')
@push('select2css')
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush
@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route("nota.index") }}">Nota</a></li>
        <li class="breadcrumb-item active">Tambah Nota</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Tambah Nota</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{ route('nota.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <!-- <label for="no_nota">No Nota</label> -->
                    <input type="text" class="form-control" id="no_nota" name="no_nota" placeholder="Masukkan No Nota" hidden value="p">

                  <div class="form-group">
                    <label for="tanggal">Tanggal<span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('tanggal') is-invalid
                    @enderror" id="tanggal" name="tanggal" placeholder="Masukkan Tanggal Nota" required value="{{ old('tanggal') }}">
                    @error('tanggal')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <!-- select -->
                    <div class="form-group">
                        <label for="nama_pegawai">Nama Pegawai<span class="text-danger">*</span></label>
                        <select class="form-control @error('pegawai_kode_pegawai') is-invalid
                        @enderror" name="pegawai_kode_pegawai" id="nama_pegawai" required>
                          <option value="">-- Pilih Pegawai --</option>
                        @foreach($pegawai as $row)
                            <option value="{{ $row->kode_pegawai }}" {{ old('pegawai_kode_pegawai') == $row->kode_pegawai ? 'selected' : '' }}>{{ $row->nama }}</option>
                        @endforeach
                        </select>
                        @error('pegawai_kode_pegawai')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                  <!-- select -->
                    <div class="form-group">
                        <label for="nama_pelanggan">Nama Pelanggan<span class="text-danger">*</span></label>
                        <select class="form-control @error('pelanggan_kode_pelanggan') is-invalid
                        @enderror" name="pelanggan_kode_pelanggan" id="nama_pelanggan" required>
                          <option value="">-- Pilih Pelanggan --</option>
                        @foreach($pelanggan as $row)
                            <option value="{{ $row->kode_pelanggan }}" {{ old('pelanggan_kode_pelanggan') == $row->kode_pelanggan ? 'selected' : '' }}>{{ $row->nama }}</option>
                        @endforeach
                        </select>
                        @error('pelanggan_kode_pelanggan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer d-flex justify-content-end">                
                  <a href="{{ route("nota.index") }}" class="btn btn-secondary mr-2">Batal</a>
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
            $('#nama_pegawai').select2({
                theme: 'bootstrap4',
                placeholder: '-- Pilih Pegawai --',
                allowClear: true
            });
            $('#nama_pelanggan').select2({
                theme: 'bootstrap4',
                placeholder: '-- Pilih Pelanggan --',
                allowClear: true
            });
        });
    </script>
@endpush