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

                <div class="d-flex justify-content-end align-items-center">
                    <!-- Tombol Tambah Nota -->
                    <a href="{{ route("nota.create") }}" class="btn btn-primary btn-sm mr-2">
                        <i class="fas fa-plus mr-1"></i> Tambah Nota
                    </a>
                    
                    <!-- Form Pencarian -->
                    @php
                    $hasSearch = request()->filled('keyword')
                              || request()->filled('status')
                              || request()->filled('bulan');
                @endphp

<form class="d-flex align-items-center">

    <input type="text"
           class="form-control form-control-sm mr-3"
           placeholder="Search"
           name="keyword"
           value="{{ request('keyword') }}">

    <select class="form-control form-control-sm mr-3" name="status">
        <option value="">Semua Status</option>
        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
        <option value="final" {{ request('status') === 'final' ? 'selected' : '' }}>Final</option>
    </select>

    <select class="form-control form-control-sm mr-3" name="bulan">
        <option value="">Semua Waktu</option>
        <option value="1" {{ request('bulan') == '1' ? 'selected' : '' }}>1 Bulan</option>
        <option value="2" {{ request('bulan') == '2' ? 'selected' : '' }}>2 Bulan</option>
        <option value="3" {{ request('bulan') == '3' ? 'selected' : '' }}>3 Bulan</option>
    </select>

    <button class="btn btn-primary btn-sm mr-2">
        <i class="fas fa-search"></i>
    </button>

    {{-- Tombol Reset --}}
    @if($hasSearch)
        <a href="{{ route('nota.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-undo"></i>
        </a>
    @else
        <button class="btn btn-secondary btn-sm" disabled>
            <i class="fas fa-undo"></i>
        </button>
    @endif

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
                      <th class="text-center">Status</th>
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
                        @if($row->draft)
                            <span class="badge badge-secondary">Draft</span>
                        @else
                            <span class="badge badge-success">Final</span>
                        @endif
                      </td>
                      <td class="text-center">
                        @if ($row->draft)
                            <a href="{{ route("nota.edit", $row->no_nota) }}" class="btn btn-sm btn-warning text-white"><i class="fas fa-edit"></i></a>
                            <form action="{{ route("nota.destroy", $row->no_nota) }}" method="POST" class="d-inline">
                              @csrf
                              @method('DELETE')
                              <button class="btn btn-sm btn-danger" onclick="return confirm('Apakah kamu yakin ingin menghapus Nota ini?')"><i class="fas fa-trash"></i>
                            </button>
                            </form>
                            <a href="{{ route("nota.show", $row->no_nota) }}" class="btn btn-sm btn-info text-white"><i class="fas fa-eye"></i></a>
                        @else
                        <a href="{{ route("nota.show", $row->no_nota) }}" class="btn btn-sm btn-info text-white"><i class="fas fa-eye"></i></a>
                        <a href="{{ route("nota.print", $row->no_nota) }}" class="btn btn-sm btn-success text-white" target="_blank"><i class="fas fa-print"></i></a>
                        <a href="{{ route("nota.download", $row->no_nota) }}" class="btn btn-sm btn-secondary text-white"><i class="fas fa-download"></i></a>
                        @endif
                        
                      </td>
                    </tr>
                @empty
                    <tr>
                      <td colspan="6" class="text-center">Tidak ada data nota</td>
                    </tr>
                @endforelse
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->

                <!-- card footer -->
                <div class="card-footer clearfix mt-2">
    <div class="float-right">
        {{ $nota->links('pagination::bootstrap-4') }}
    </div>
</div>

                <!-- end card footer -->
            </div>
            <!-- end tabel Nota -->
          </div>
    </div>
@endsection