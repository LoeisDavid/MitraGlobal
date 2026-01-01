@extends('layouts.app')

@section('title', 'Data Nota')
@section('page-title', 'Nota')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item active">Nota</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
        <!-- tabel Nota -->
            <div class="card">
            <!-- card header -->
              <div class="card-header">
                <h3 class="card-title p-1">Data Nota</h3>

                <div class="card-tools d-flex align-items-center">
                    <!-- Tombol Tambah Nota -->
                    <a href="{{ route("nota.create") }}" class="btn btn-primary btn-sm mr-2">
                        <i class="fas fa-plus mr-1"></i> Tambah Nota
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
                      <th>No Nota</th>
                      <th>Tanggal</th>
                      <th>Nama Pegawai</th>
                      <th>Nama Pelanggan</th>
                      <th class="text-center">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                @forelse($nota as $row)
                    <tr>
                      <td>{{ $row->no_nota }}</td>
                      <td>{{ \Carbon\Carbon::parse($row->tanggal)->translatedFormat('d F Y') }}</td>
                      <td>{{ $row->pegawai->nama }}</td>
                      <td>{{ $row->pelanggan->nama }}</td>
                      <td class="text-center">
                        <a href="{{ route("nota.show", $row->no_nota) }}" class="btn btn-sm btn-info text-white"><i class="fas fa-eye"></i></a>
                        <form action="#" method="POST" class="d-inline">
                          
                          <button class="btn btn-sm btn-success" onclick="return confirm('Apakah kamu yakin ingin menghapus Nota ini?')"><i class="fas fa-print"></i>
                        </button>
                        </form>
                      </td>
                    </tr>
                @empty
                    <tr>
                      <td colspan="5" class="text-center">Tidak ada data nota</td>
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
            <!-- end tabel Nota -->
          </div>
    </div>
@endsection