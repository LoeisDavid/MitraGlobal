@extends('layouts.app')

@section('title', 'Detail Nota')
@section('page-title', 'Detail Nota')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route("nota.index") }}">Nota</a></li>
        <li class="breadcrumb-item active">Detail Nota</li>
    </ol>
@endsection

@section('content')
    <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                    <i class="fas fa-globe"></i> Mitra Global
                    <small class="float-right">Tanggal: {{ \Carbon\Carbon::parse($nota->tanggal)->translatedFormat('d F Y') }}</small>
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                  Pegawai
                  <address>
                    <strong>Admin, Inc.</strong><br>
                    795 Folsom Ave, Suite 600<br>
                    San Francisco, CA 94107<br>
                    Phone: (804) 123-5432<br>
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  Pelanggan
                  <address>
                    <strong>{{ $nota->pelanggan->nama }}</strong><br>
                    {{ $nota->pelanggan->alamat }}<br>
                    Telepon: {{ $nota->pelanggan->telepon }}<br>
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <b>No Nota #{{ $nota->no_nota }}</b><br>
                  <b>Status: @if ($nota->draft)
                    <span class="badge badge-secondary p-1">Draft</span>
                  @else
                    <span class="badge badge-success">Final</span>
                  @endif
                </b>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                    <tr>
                      <th>Nama Barang</th>
                      <th class="text-right">Qty</th>
                      <th class="text-right">Harga</th>
                      <th class="text-right">Diskon</th>
                      <th class="text-right">Subtotal</th>
                      @if ($nota->draft)
                      <th class="text-center">Aksi</th>
                      @endif
                    </tr>
                    </thead>
                    <tbody>
                      @forelse ($detils as $detil)
                    <tr>
                      <td>{{ $detil->barang->nama }}</td>
                      <td class="text-right">{{ $detil->jumlah }}</td>
                      <td class="text-right">Rp. {{ number_format($detil->harga, 0, ',', '.') }}</td>
                      <td class="text-right">{{ $detil->diskon }}%</td>
                      <td class="text-right">Rp. {{ number_format($detil->jumlah * $detil->harga - ($detil->jumlah * $detil->harga * $detil->diskon / 100), 0, ',', '.') }}</td>
                      @if ($nota->draft)
                      <td class="text-center">
                        <a href="{{ route('nota_barang.edit', $detil->id) }}"
                          class="btn btn-sm btn-warning text-white">
                            <i class="fas fa-edit"></i>
                        </a>

                        <form action="{{ route('nota_barang.destroy', ['no_nota' => $nota->no_nota, 'id' => $detil->id]) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                      </td>
                      @endif
                    </tr>
                    @empty
                    <tr>
                      <td colspan="{{ $nota->draft ? 6 : 5 }}" class="text-center">Tidak ada data barang.</td>
                    </tr>
                    @endforelse
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <div class="row">
                <!-- Tambah Barang -->
                
                <div class="col-6">
                  @if ($nota->draft)
                    <a href="{{ route('nota_barang.create', $nota->no_nota) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah Barang
                    </a>
                  @endif
                </div>
                
                <!-- /.col -->
                <div class="col-6">
                  <p class="lead">Tanggal {{ $nota->tanggal }}</p>
                <!-- tabel ringkasan total -->
                  <div class="table-responsive float-right">
                    <table class="table">
                      <tbody><tr>
                        <th style="width:50%">Subtotal:</th>
                        <td>{{ number_format($subtotal, 0, ',', '.') }}</td>
                      </tr>
                      <tr>
                        <th>Diskon:</th>
                        <td>{{ number_format($totalDiskon, 0, ',', '.') }}</td>
                      </tr>
                      <tr>
                        <th>Total:</th>
                        <td>{{ number_format($total, 0, ',', '.') }}</td>
                      </tr>
                    </tbody></table>
                  </div>
                  <!-- end tabel ringkasan total -->

                  <!-- tombol simpan draft -->
                  @if ($nota->draft)
                  <div class="col-12">
                  <form action="{{ route('nota.finalize', $nota->no_nota) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#finalizeModal">
                    <i class="fas fa-check-circle mr-1"></i> 
                    Finalisasi Nota
                  </button>
                  <!-- Modal -->
                    <div class="modal fade" id="finalizeModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="finalizeModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="finalizeModalLabel">Finalisasi Nota</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            Apakah Anda yakin ingin memfinalisasi nota ini? Setelah difinalisasi, nota tidak dapat diubah kembali.
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Oke</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
                  @endif
                  <!-- end tombol simpan draft -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
              </div>
            </div>
@endsection