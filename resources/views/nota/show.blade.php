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
                      <th class="text-right">Harga</th>
                      <th class="text-right">Qty</th>
                      <th class="text-right">Diskon</th>
                      <th class="text-right">Subtotal</th>
                      <th class="text-center">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                      <td>Call of Duty</td>
                      <td class="text-right">Rp. 200.000</td>
                      <td class="text-right">1</td>
                      <td class="text-right">10</td>
                      <td class="text-right">$64.50</td>
                      <td class="text-center">
                        <a href="#" class="btn btn-sm btn-warning text-white">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="#" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                      </td>
                    </tr>
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <div class="row">
                <!-- accepted payments column -->
                <div class="col-6">
                    <a href="#" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah Barang
                    </a>
                </div>
                <!-- /.col -->
                <div class="col-6">
                  <p class="lead">Tanggal 2/22/2014</p>

                  <div class="table-responsive">
                    <table class="table">
                      <tbody><tr>
                        <th style="width:50%">Subtotal:</th>
                        <td>$250.30</td>
                      </tr>
                      <tr>
                        <th>Diskon:</th>
                        <td>$10.34</td>
                      <tr>
                        <th>Total:</th>
                        <td>$265.24</td>
                      </tr>
                    </tbody></table>
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
              </div>
            </div>
@endsection