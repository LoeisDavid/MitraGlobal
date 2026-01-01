@extends('layouts.app')

@section('title', 'Tambah Nota')
@section('page-title', 'Form Nota')

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
                  <div class="form-group">
                    <label for="no_nota">No Nota</label>
                    <input type="text" class="form-control" id="no_nota" name="no_nota" placeholder="Masukkan No Nota">
                  </div>
                  <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" class="form-control" id="tanggal" name="tanggal" placeholder="Masukkan Tanggal Nota" required>
                  </div>
                  <!-- select -->
                    <div class="form-group">
                        <label>Nama Pegawai</label>
                        <select class="form-control">
                        <option>option 1</option>
                        <option>option 2</option>
                        </select>
                    </div>
                  <!-- select -->
                    <div class="form-group">
                        <label>Nama Pelanggan</label>
                        <select class="form-control">
                        <option>option 1</option>
                        <option>option 2</option>
                        </select>
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