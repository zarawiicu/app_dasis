 {{-- Footer --}}
 <footer class="main-footer">
     <strong>Copyright &copy;
         {{ date('Y') }} <a href="#">Zarawiicu_<img src="{{ asset('template/dist/img/love.png') }}"
                 width="15" height="15"></a>.</strong>
     All rights reserved.
 </footer>
 </div>
 <!-- ./wrapper -->

 <!-- REQUIRED SCRIPTS -->

 <!-- jQuery -->
 <script src="{{ asset('template/plugins/jquery/jquery.min.js') }}"></script>
 <!-- AdminLTE App -->
 <script src="{{ asset('template/dist/js/adminlte.js') }}"></script>
 <script src="{{ asset('template/dist/js/pages/dashboard2.js') }}"></script>

 <!-- Bootstrap -->
 <script src="{{ asset('template/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
 <!-- overlayScrollbars -->
 <script src="{{ asset('template/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>

 <!-- PAGE PLUGINS -->
 <!-- jQuery Mapael -->
 <script src="{{ asset('template/plugins/jquery-mousewheel/jquery.mousewheel.js') }}"></script>
 <script src="{{ asset('template/plugins/raphael/raphael.min.js') }}"></script>
 <script src="{{ asset('template/plugins/jquery-mapael/jquery.mapael.min.js') }}"></script>
 <script src></script>
 <!-- ChartJS -->
 <script src="{{ asset('template/plugins/chart.js/Chart.min.js') }}"></script>

 <!-- AdminLTE for demo purposes -->
 <script src="{{ asset('template/dist/js/demo.js') }}"></script>
 <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
 <script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 <script>
     $(document).ready(function() {
         $('#logout-link').on('click', function(e) {
             e.preventDefault();
             Swal.fire({
                 title: 'Are you sure?',
                 text: "You will be logged out.",
                 icon: 'warning',
                 showCancelButton: true,
                 confirmButtonColor: '#3085d6',
                 cancelButtonColor: '#d33',
                 confirmButtonText: 'Yes, logout!'
             }).then((result) => {
                 if (result.isConfirmed) {
                     $('#logout-form').submit();
                 }
             });
         });
     });
 </script>
 <script>
     $.ajaxSetup({
         headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
     });
 </script>
 </body>

 </html>
