@extends('layouts.app')

@section('title', 'Data Barang')
@section('page-title', 'Barang')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item active">Barang</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
        <!-- tabel Barang -->
            <div class="card">
            <!-- card header -->
              <div class="card-header">
                <h3 class="card-title p-1">Data Barang</h3>

                <div class="card-tools d-flex align-items-center">
                    <!-- Tombol Tambah Barang -->
                    <a href="{{ route("barang.create") }}" class="btn btn-primary btn-sm mr-2">
                        <i class="fas fa-plus mr-1"></i> Tambah Barang
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
                      <th>Kode Barang</th>
                      <th>Nama Barang</th>
                      <th>Kategori</th>
                      <th>Merek</th>
                      <th>Harga Jual</th>
                      <th>Stok</th>
                      <th class="text-center">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($barangs as $barang)
                    <tr>
                      <td>{{ $barang->kode_barang }}</td>
                      <td>{{ $barang->nama }}</td>
                      <td>{{ $barang->kategori->nama }}</td>
                      <td>{{ $barang->merk->nama }}</td>
                      <td>{{ $barang->harga_jual }}</td>
                      <td>{{ $barang->stok }}</td>
                      <td class="text-center">
                        <a href="{{ route('barang.edit', ['kode_barang' => $barang->kode_barang]) }}" class="btn btn-sm btn-warning text-white"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('barang.destroy', ['kode_barang' => $barang->kode_barang]) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                          <button class="btn btn-sm btn-danger" onclick="return confirm('Apakah kamu yakin ingin menghapus Barang ini?')"><i class="fas fa-trash"></i>
                        </button>
                        </form>
                      </td>
                    </tr>
                    @empty
                    <tr>
                      <td colspan="7" class="text-center">Tidak ada data Barang.</td>
                    </tr>
                    @endforelse
                
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
            <!-- end tabel Barang -->
          </div>
    </div>
@endsection