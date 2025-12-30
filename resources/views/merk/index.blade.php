@extends('layouts.app')

@section('title', 'Kategori')
@section('page-title', 'Kategori')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item active">Kategori</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
        <!-- tabel kategori -->
            <div class="card">
            <!-- card header -->
              <div class="card-header">
                <h3 class="card-title p-1">Data Kategori</h3>

                <div class="card-tools d-flex align-items-center">
                    <!-- Tombol Tambah Kategori -->
                    <a href="{{ route("kategori.create") }}" class="btn btn-primary btn-sm mr-2">
                        <i class="fas fa-plus mr-1"></i> Tambah Kategori
                    </a>
                    
                    <!-- Form Pencarian -->
                    <form class="d-flex">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="table_search" class="form-control" placeholder="Search">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
              </div>
              <!-- end card-header -->

              <!-- card body -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>Kode Kategori</th>
                      <th>Nama Kategori</th>
                      <th class="text-center">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>N098</td>
                      <td>ATK</td>
                      <td class="text-center">
                        <a class="btn btn-sm btn-warning text-white"><i class="fas fa-edit"></i></a>
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Apakah kamu yakin ingin menghapus kategori ini?')"><i class="fas fa-trash"></i></button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->

                <!-- card footer -->
                <div class="card-footer clearfix mt-2">
                    <ul class="pagination pagination-sm m-0 float-right">
                    <li class="page-item"><a class="page-link" href="#">«</a></li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">»</a></li>
                    </ul>
                </div>
                <!-- end card footer -->
            </div>
            <!-- end tabel kategori -->
          </div>
    </div>
@endsection