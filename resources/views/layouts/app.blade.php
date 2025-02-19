<!DOCTYPE html>
<html lang="en" class="dark-mode">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'AppDasis')</title>
    <!-- Include CSS template yang telah Anda download -->
    <link rel="stylesheet" href="{{ asset('template/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="{{ asset('template/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet">
    @stack('styles')
</head>
<body class="hold-transition sidebar-mini dark-mode">
<div class="wrapper">
    @include('layouts.header')
    @include('layouts.sidebar')
    
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <h1>@yield('page_header', 'Page Header')</h1>
            </div>
        </section>

        <section class="content">
            @yield('content')
        </section>
    </div>
    
    @include('layouts.footer')
</div>
<!-- jQuery -->
<script src="{{ asset('template/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('template/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- DataTables & Plugins -->
<script src="{{ asset('template/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('template/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('template/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('template/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<!-- template App -->
<script src="{{ asset('template/dist/js/template.min.js') }}"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
@stack('scripts')
@yield('js')
</body>
</html>
