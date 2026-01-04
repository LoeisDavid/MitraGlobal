  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      

      <li class="nav-item dropdown">
    @php
        $totalNotif = count($lowStockBarangs);
    @endphp

    <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-bell"></i>
        @if($totalNotif > 0)
            <span class="badge badge-warning navbar-badge">{{ $totalNotif }}</span>
        @endif
    </a>

    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-header">
            Kamu punya {{ $totalNotif }} stok notifikasi
        </span>
        <div class="dropdown-divider"></div>

        <div class="notif-scroll">
            @forelse($lowStockBarangs as $barang)
                <a href="{{ route('barang.edit', $barang->kode_barang) }}" class="dropdown-item">
                    <div class="media">
                        @if($barang->stok == 0)
                            <i class="fas fa-exclamation-circle text-danger fa-2x mr-3"></i>
                        @else
                            <i class="fas fa-exclamation-triangle text-warning fa-2x mr-3"></i>
                        @endif

                        <div class="media-body">
                            <h3 class="dropdown-item-title font-weight-bold mb-1">
                                {{ $barang->nama }}
                            </h3>
                            <p class="text-sm mb-0 text-wrap">
                                <strong>{{ $barang->stok == 0 ? 'Stok habis!' : 'Stok hampir habis!' }}</strong> 
                                Segera isi stok barang ini.
                            </p>
                        </div>
                    </div>
                </a>
                <div class="dropdown-divider"></div>
            @empty
                <p class="text-sm text-center py-3 mb-0">Tidak ada notifikasi stok rendah.</p>
            @endforelse
        </div>

        <a href="{{ route('barang.index') }}" class="dropdown-item dropdown-footer">
            Lihat Semua Notifikasi
        </a>
    </div>
</li>


      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->