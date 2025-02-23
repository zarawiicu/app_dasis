@extends('layouts.app')

@section('title', 'Manajemen Kota')
@section('page_header', 'Daftar Kota')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <button class="btn btn-primary" id="add-btn">Tambah Kota</button>
                <form method="GET" action="{{ route('kota.index') }}" class="float-right">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kota..."
                        class="form-control d-inline w-auto">
                    <button type="submit" class="btn btn-success">Cari</button>
                </form>
            </div>
            <div class="card-body">
                <!-- Tempat untuk memuat data tabel secara AJAX -->
                <div id="data-container">
                    @include('kota.table')
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah/Edit -->
    <div class="modal fade" id="kotaModal" tabindex="-1" role="dialog" aria-labelledby="kotaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form id="kotaForm" method="POST" action="{{ route('kota.store') }}">
                @csrf
                <div id="method_field"></div>
                <input type="hidden" id="kota_id" name="id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">Tambah Kota</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label>Nama Kota</label>
                        <input type="text" class="form-control" name="nama_kota" id="nama_kota" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Show Data -->
    <div class="modal fade" id="showModal" tabindex="-1" role="dialog" aria-labelledby="showModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="showModalLabel" class="modal-title">Detail Kota</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>ID:</strong> <span id="detail-id"></span></p>
                    <p><strong>Nama Kota:</strong> <span id="detail-nama"></span></p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Fungsi untuk memuat data tabel secara AJAX (untuk search, sort, pagination)
            function fetchData(url) {
                $.ajax({
                    url: url,
                    type: "GET",
                    beforeSend: function() {
                        $('#data-container').html('<div class="text-center">Loading...</div>');
                    },
                    success: function(response) {
                        $('#data-container').html(response);
                    },
                    error: function(xhr) {
                        alert("Terjadi kesalahan saat memuat data.");
                    }
                });
            }

            // Event handler untuk pagination dan sort (delegated event agar bekerja dengan konten AJAX)
            $(document).on('click', '.pagination a, .sort-link', function(e) {
                e.preventDefault();
                let url = $(this).attr('href') || "{{ route('kota.index') }}?sort_by=" + $(this).data('sort') +
                    "&sort_type=" + ($(this).data('sort-type') || 'asc');
                fetchData(url);
            });

            // Event handler untuk search 
            $('input[name="search"]').on('keyup', function() {
                let query = $(this).val();
                fetchData("{{ route('kota.index') }}?search=" + query);
            });

            // Event handler untuk pagination dan sort (reset search input)
            $(document).on('click', '.pagination a, .sort-link', function(e) {
                e.preventDefault();
                let url = $(this).attr('href') || "{{ route('kota.index') }}?sort_by=" + $(this).data('sort') +
                    "&sort_type=" + ($(this).data('sort-type') || 'asc');
                fetchData(url);
                $('input[name="search"]').val('');
            });

            // Modal & AJAX CRUD
            $('#add-btn').click(function() {
                $('#modalTitle').text('Tambah Kota');
                $('#kotaForm').attr('action', '/kota'); // action untuk tambah data
                $('#kota_id').val('');
                $('#nama_kota').val('');
                $('#method_field').html('');
                $('#kotaModal').modal('show');
            });

            // Submit form untuk tambah/edit
            $('#kotaForm').submit(function(e) {
                e.preventDefault();
                let id = $('#kota_id').val();
                let url = id ? "/kota/" + id : "/kota";
                // Selalu gunakan metode POST, lalu override method jika update
                let data = {
                    nama_kota: $('#nama_kota').val(),
                    _token: "{{ csrf_token() }}"
                };
                if (id) {
                    data._method = "PUT"; // override method untuk update
                }

                $.ajax({
                    url: url,
                    type: "POST", // gunakan POST untuk kedua kasus (tambah dan update)
                    data: data,
                    success: function(response) {
                        $('#kotaModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: id ? 'Data berhasil diperbarui!' : 'Data berhasil ditambahkan!',
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {
                            fetchData("{{ route('kota.index') }}");
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Terjadi kesalahan saat menyimpan data.'
                        });
                    }
                });
            });

            // Event handler untuk Edit
            $(document).on('click', '.edit-btn', function() {
                let id = $(this).data('id');
                let nama = $(this).data('nama');

                $('#modalTitle').text('Edit Kota');
                $('#kotaForm').attr('action', '/kota/' + id); // URL update
                $('#kota_id').val(id); // Pastikan field ini terisi
                $('#nama_kota').val(nama);
                // Meskipun kita menambahkan input hidden untuk _method di form, kita akan
                // melakukan override melalui data AJAX agar lebih konsisten.
                $('#method_field').html('<input type="hidden" name="_method" value="PUT">');
                $('#kotaModal').modal('show');
            });

            // Event handler untuk Show detail
            $(document).on('click', '.show-btn', function() {
                let id = $(this).data('id');
                $.ajax({
                    url: "/kota/" + id,
                    type: "GET",
                    success: function(response) {
                        $('#detail-id').text(response.id);
                        $('#detail-nama').text(response.nama_kota);
                        $('#showModal').modal('show');
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Data tidak ditemukan!'
                        });
                    }
                });
            });

            // Event handler untuk Delete
            $(document).on('click', '.delete-btn', function() {
                let id = $(this).data('id');

                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: "Data yang dihapus tidak bisa dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "/kota/" + id,
                            type: "POST",
                            data: {
                                _method: "DELETE",
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Data berhasil dihapus!',
                                    showConfirmButton: false,
                                    timer: 2000
                                }).then(() => {
                                    fetchData("{{ route('kota.index') }}");
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Terjadi kesalahan saat menghapus data.'
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
