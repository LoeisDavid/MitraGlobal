  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link text-center">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

        <li class="nav-item">
          <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
          </a>
        </li>
        <!-- Master Data -->
        <li class="nav-header">MASTER DATA</li>
            <li class="nav-item">
                <a href="pages/gallery.html" class="nav-link">
                <i class="nav-icon far fa-image"></i>
                <p>
                    Gallery
                </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route("kategori.index") }}" class="nav-link">
                <i class="nav-icon fas fa-tags"></i>
                <p>
                    Kategori
                </p>
                </a>
            </li>
        <!-- End Master Data -->
        <li class="nav-header">EXAMPLES</li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
