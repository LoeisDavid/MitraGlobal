@extends('layouts.app')

@section('title', 'Data Pegawai')
@section('page-title', 'Pegawai')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item active">Pegawai</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
        <!-- tabel Pegawai -->
            <div class="card">
            <!-- card header -->
              <div class="card-header">
                <h3 class="card-title p-1">Data Pegawai</h3>

                <div class="card-tools d-flex align-items-center">
                    <!-- Tombol Tambah Pegawai -->
                    <a href="{{ route("pegawai.create") }}" class="btn btn-primary btn-sm mr-2">
                        <i class="fas fa-plus mr-1"></i> Tambah Pegawai
                    </a>
                    
                    <!-- Form Pencarian -->
                    <form class="d-flex" method="get" action="{{ route('pegawai.index') }}">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="search" class="form-control" placeholder="Search" value="{{ $keyword ?? '' }}">
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
                      <th>Kode Pegawai</th>
                      <th>Nama Pegawai</th>
                      <th>Username</th>
                      <th class="text-center">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                  @forelse($data as $pegawai)
                    <tr>
                      <td>{{ $pegawai->kode_pegawai }}</td>
                      <td>{{ $pegawai->nama }}</td>
                      <td>{{ $pegawai->username }}</td>
                      <td class="text-center">
                        <a href="{{ route("pegawai.edit", $pegawai->kode_pegawai) }}" class="btn btn-sm btn-warning text-white"><i class="fas fa-edit"></i></a>
                        <form action="{{ route("pegawai.destroy", $pegawai->kode_pegawai) }}" method="POST" class="d-inline">
                          @csrf
                          @method('DELETE')
                          <button class="btn btn-sm btn-danger" onclick="return confirm('Apakah kamu yakin ingin menghapus Pegawai ini?')"><i class="fas fa-trash"></i>
                        </button>
                        </form>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="4" class="text-center">Tidak ada data Pegawai.</td>
                    </tr>
                  @endforelse
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->

                <!-- card footer -->
                <div class="card-footer clearfix mt-2">
    <div class="float-right">
        {{ $data->links('pagination::bootstrap-4') }}
    </div>
</div>

                <!-- end card footer -->
            </div>
            <!-- end tabel Pegawai -->
          </div>
    </div>
@endsection