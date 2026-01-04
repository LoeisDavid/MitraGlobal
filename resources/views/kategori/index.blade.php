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
                    <form class="d-flex" method="get" action="{{ route('kategori.index') }}">
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
                      <th>Kode Kategori</th>
                      <th>Nama Kategori</th>
                      <th class="text-center">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                  @forelse ($kategori as $row)
                    <tr>
                      <td>{{ $row->kode_kategori }}</td>
                      <td>{{ $row->nama }}</td>
                      <td class="text-center">
                        <a href="{{ route("kategori.edit", $row->kode_kategori) }}" class="btn btn-sm btn-warning text-white"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('kategori.destroy', $row->kode_kategori) }}" method="POST" class="d-inline">
                          @csrf
                          @method('DELETE')
                          <button class="btn btn-sm btn-danger" onclick="return confirm('Apakah kamu yakin ingin menghapus kategori ini?')"><i class="fas fa-trash"></i>
                        </button>
                        </form>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="3" class="text-center">Tidak ada data kategori.</td>
                    </tr>
                  @endforelse
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->

                <!-- card footer -->
                <div class="card-footer clearfix mt-2">
    <div class="float-right">
        {{ $kategori->links('pagination::bootstrap-4') }}
    </div>
</div>

                <!-- end card footer -->
            </div>
            <!-- end tabel kategori -->
          </div>
    </div>
@endsection