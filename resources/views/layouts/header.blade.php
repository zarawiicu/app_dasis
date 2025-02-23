<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dasis App</title>

    <link rel="shortcut icon" type="image/png" href="{{ asset('template/dist/img/logo48.png') }}">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('template/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('template/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('template/dist/css/adminlte.min.css') }}">
    
</head>

<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-centerf align-items-center">
            <img class="animation__wobble rounded-circle" src="{{ asset('template/dist/img/roket2.png') }}"
                alt="AdminLTELogo" height="60" width="60" style="margin-top: 20%!important;">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                      <i class="fas fa-bars"></i>
                  </a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <span class="d-none d-md-inline-block"
                    style="padding-right:3px;padding-top:10%">{{ Auth::user()->username }}</span>
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                        <img src="{{ asset('template/dist/img/pp.jpg') }}" alt="User Avatar"
                            class="img-circle elevation-2" style="width:30px;height:30px;cursor:pointer;">
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="#logout-form" class="dropdown-item" id="logout-link">
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            <i class="fas fa-lock mr-2"></i> Logout
                        </a>
                    </div>
                </li>
            </ul>

            <!-- Tambahkan script Bootstrap jika belum ada -->
            <script src="{{ asset('template/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

        </nav>
        <!-- /.navbar -->

        <!-- Script dan lainnya -->
        <script src="{{ asset('template/plugins/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('template/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('template/dist/js/adminlte.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
          $(document).ready(function() {
              $('[data-widget="pushmenu"]').on('click', function() {
                  $('body').toggleClass('sidebar-collapse');
              });
          });
          </script>
          
