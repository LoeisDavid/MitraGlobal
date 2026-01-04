  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link text-center">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

  <!-- Sidebar -->
<div class="sidebar d-flex flex-column">

  <!-- Sidebar Menu -->
  <nav class="mt-2 flex-grow-1">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <!-- menu kamu yang tadi, TIDAK DIUBAH -->
      <li class="nav-item">
          <a href="{{ route("dashboard.index") }}" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
          </a>
        </li>
        <!-- Master Data -->
        <li class="nav-header">MASTER DATA</li>
            <li class="nav-item">
                <a href="{{ route("barang.index") }}" class="nav-link">
                <i class="nav-icon fas fa-box"></i>
                <p>
                    Barang
                </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route("kategori.index") }}" class="nav-link">
                <i class="nav-icon fas fa-list"></i>
                <p>
                    Kategori
                </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route("merk.index") }}" class="nav-link">
                <i class="nav-icon fas fa-tags"></i>
                <p>
                    Merk
                </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route("pelanggan.index") }}" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p>
                    Pelanggan
                </p>
                </a>
            </li>
        <!-- End Master Data -->

        <!-- Transaksi -->
        <li class="nav-header">Transaksi</li>
            <li class="nav-item">
                <a href="{{ route("nota.index") }}" class="nav-link">
                <i class="nav-icon fas fa-receipt"></i>
                <p>
                    Nota
                </p>
                </a>
            </li>
        <!-- End Transaksi -->
        <li class="nav-header">Manajemen Pegawai</li>
            <li class="nav-item">
                <a href="{{ route("pegawai.index") }}" class="nav-link">
                <i class="nav-icon fas fa-user-tie"></i>
                <p>
                    Pegawai
                </p>
                </a>
            </li>
    </ul>
  </nav>
  <!-- /.sidebar-menu -->

  <!-- LOGOUT (BOTTOM) -->
  <div class="p-3 border-top">
    <form action="{{ route('logout') }}" method="POST">
      @csrf
      <button type="submit" class="btn btn-danger btn-block">
        <i class="fas fa-sign-out-alt mr-2"></i>
        Logout
      </button>
    </form>
  </div>

</div>
<!-- /.sidebar -->li>
  </aside>
