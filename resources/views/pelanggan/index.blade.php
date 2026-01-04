@extends('layouts.app')

@section('title', 'Pelanggan')
@section('page-title', 'Pelanggan')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item active">Pelanggan</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
        <!-- tabel Pelanggan -->
            <div class="card">
            <!-- card header -->
              <div class="card-header">
                <h3 class="card-title p-1">Data Pelanggan</h3>

                <div class="card-tools d-flex align-items-center">
                    <!-- Tombol Tambah Pelanggan -->
                    <a href="{{ route("pelanggan.create") }}" class="btn btn-primary btn-sm mr-2">
                        <i class="fas fa-plus mr-1"></i> Tambah Pelanggan
                    </a>
                    
                    <!-- Form Pencarian -->
                    <form class="d-flex" method="get" action="{{ route('pelanggan.index') }}">
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
                      <th>Kode Pelanggan</th>
                      <th>Nama Pelanggan</th>
                      <th>Alamat</th>
                      <th>Telepon</th>
                      <th class="text-center">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                @forelse ($pelanggan as $row)    
                    <tr>
                      <td>{{ $row->kode_pelanggan }}</td>
                      <td>{{ $row->nama }}</td>
                      <td>{{ $row->alamat }}</td>
                      <td>{{ $row->telepon }}</td>
                      <td class="text-center">
                        <a href="{{ route("pelanggan.edit", $row->kode_pelanggan) }}" class="btn btn-sm btn-warning text-white"><i class="fas fa-edit"></i></a>
                        <form action="{{ route("pelanggan.destroy", $row->kode_pelanggan) }}" method="POST" class="d-inline">
                          @csrf
                          @method('DELETE')
                          <button class="btn btn-sm btn-danger" onclick="return confirm('Apakah kamu yakin ingin menghapus Pelanggan ini?')"><i class="fas fa-trash"></i>
                        </button>
                        </form>
                      </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Data pelanggan tidak tersedia</td>
                    </tr>
                @endforelse
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->

                <!-- card footer -->
                <div class="card-footer clearfix mt-2">
    <div class="float-right">
        {{ $pelanggan->links('pagination::bootstrap-4') }}
    </div>
</div>

                <!-- end card footer -->
            </div>
            <!-- end tabel Pelanggan -->
          </div>
    </div>
@endsection