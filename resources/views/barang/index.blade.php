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
                    <form class="d-flex" method="GET" action="{{ route('barang.index') }}">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="keyword" class="form-control" placeholder="Search" value="{{ $keyword ?? '' }}">
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
                      <th>Harga Beli</th>
                      <th>Diskon</th>
                      <th>Modal</th>
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
                      <td>Rp. {{ number_format($barang->harga_beli, 0, ',', '.') }}</td>
                      <td>{{ number_format($barang->diskon, 0, ',', '.') }}%</td>
                      <td>Rp. {{ number_format($barang->modal(), 0, ',', '.') }}</td>
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
    <div class="float-right">
        {{ $barangs->links('pagination::bootstrap-4') }}
    </div>
</div>

                <!-- end card footer -->
            </div>
            <!-- end tabel Barang -->
          </div>
    </div>
@endsection