@extends('layouts.app')

@section('title', 'Merk')
@section('page-title', 'Merk')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item active">Merk</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
        <!-- tabel Merk -->
            <div class="card">
            <!-- card header -->
              <div class="card-header">
                <h3 class="card-title p-1">Data Merk</h3>

                <div class="card-tools d-flex align-items-center">
                    <!-- Tombol Tambah Merk -->
                    <a href="{{ route("merk.create") }}" class="btn btn-primary btn-sm mr-2">
                        <i class="fas fa-plus mr-1"></i> Tambah Merk
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
                      <th>Kode Merk</th>
                      <th>Nama Merk</th>
                      <th class="text-center">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($data as $merk)
                    <tr>
                      <td>{{ $merk->kode_merk }}</td>
                      <td>{{ $merk->nama }}</td>
                      <td class="text-center">
                        <a href="{{ route('merk.edit', $merk->kode_merk) }}" class="btn btn-sm btn-warning text-white"><i class="fas fa-edit"></i></a>
                        
                        <form action="{{ route('merk.destroy', $merk->kode_merk) }}" method="post" style="display:inline;">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                            <i class="fas fa-trash"></i>
                          </button>
                          </form>
                      </td>
                    </tr>
                    @empty
                    <tr>
                      <td colspan="3" class="text-center">Data Merk tidak tersedia</td>
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
            <!-- end tabel Merk -->
          </div>
    </div>
@endsection