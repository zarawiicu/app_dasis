<aside class="main-sidebar sidebar-dark-primary elevation-4" style="height: 100vh; overflow-y: auto;">
  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link">
    <img src="{{ asset('template/dist/img/logo48.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-bold ">Dasis App</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar" id="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="{{ route('dashboard') }}" class="nav-link">
            <i class="nav-icon fas fa-solid fa-home"></i>
            <p>Dashboard</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('siswa.index') }}" class="nav-link">
            <i class="nav-icon fas fa-solid fa-user"></i>
            <p>Siswa</p>
          </a>
      </li>
          <li class="nav-item">
              <a href="{{ route('kota.index') }}" class="nav-link">
                <i class="nav-icon fas fa-solid fa-map-pin"></i>
                <p>Kota</p>
              </a>
          </li>      
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>

<script>
  $(document).ready(function() {
    $('.btn-pushmenu').on('click', function() {
      if ($('#sidebar').hasClass('sidebar-collapse')) {
        $('#sidebar').removeClass('sidebar-collapse');
      } else {
        $('#sidebar').addClass('sidebar-collapse');
      }
    });
  });
</script>