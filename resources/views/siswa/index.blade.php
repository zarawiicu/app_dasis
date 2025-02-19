@extends('layouts.app')

@section('title', 'Manajemen Siswa')
@section('page_header', 'Daftar Siswa')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <!-- Tombol Tambah -->
                <button class="btn btn-primary" id="add-btn">Tambah Siswa</button>
                <!-- Form Pencarian -->
                <form method="GET" action="{{ route('siswa.index') }}" class="float-right">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Siswa..."
                        class="form-control d-inline w-auto">
                    <button type="submit" class="btn btn-success">Cari Siswa...</button>
                </form>
            </div>
            <div class="card-body">
                <!-- Tempat untuk memuat data tabel via AJAX -->
                <div id="data-container">
                    @include('siswa.table')
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah/Edit Siswa -->
    <div class="modal fade" id="siswaModal" tabindex="-1" role="dialog" aria-labelledby="siswaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="siswaForm">
                @csrf
                <div id="method_field"></div>
                <input type="hidden" id="id" name="id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="siswaModalLabel">Tambah Siswa</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Field NISN -->
                        <div class="form-group">
                            <label for="nisn">NISN</label>
                            <input type="text" class="form-control" id="nisn" name="nisn"
                                placeholder="Masukkan NISN" required>
                        </div>
                        <!-- Field Nama -->
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama"
                                placeholder="Masukkan Nama" required>
                        </div>
                        <!-- Field Tanggal Lahir -->
                        <div class="form-group">
                            <label for="tgl_lahir">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" required>
                        </div>
                        <!-- Field Jenis Kelamin -->
                        <div class="form-group">
                            <label for="jenis_kelamin">Jenis Kelamin</label>
                            <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                                <option value="" selected disabled>Pilih Jenis Kelamin</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <!-- Field Alamat -->
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" placeholder="Masukkan alamat" required></textarea>
                        </div>
                        <!-- Field Kota -->
                        <div class="form-group">
                            <label for="id_kota">Kota</label>
                            <select class="form-control" id="id_kota" name="id_kota" required>
                                <option value="" disabled selected>Pilih Kota</option>
                                @foreach ($kota as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama_kota }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary" id="save-btn">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Detail Siswa -->
    <div class="modal fade" id="showModal" tabindex="-1" role="dialog" aria-labelledby="showModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="showModalLabel" class="modal-title">Detail Siswa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>ID: </strong><span id="detail-id"></span></p>
                    <p><strong>NISN: </strong><span id="detail-nisn"></span></p>
                    <p><strong>Nama: </strong><span id="detail-nama"></span></p>
                    <p><strong>Tanggal Lahir: </strong><span id="detail-tgl_lahir"></span></p>
                    <p><strong>Jenis Kelamin: </strong><span id="detail-jenis_kelamin"></span></p>
                    <p><strong>Alamat: </strong><span id="detail-alamat"></span></p>
                    <p><strong>Kota: </strong><span id="detail-kota"></span></p>
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
        // Setup CSRF token untuk AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

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
                let url = $(this).attr('href') || "{{ route('siswa.index') }}?sort_by=" + $(this).data(
                    'sort') + "&sort_type=" + ($(this).data('sort-type') || 'asc');
                fetchData(url);
            });

            // Event handler untuk search 
            $('input[name="search"]').on('keyup', function() {
                let query = $(this).val();
                fetchData("{{ route('siswa.index') }}?search=" + query);
            });

            // Event handler untuk pagination dan sort 
            $(document).on('click', '.pagination a, .sort-link', function(e) {
                e.preventDefault();
                let url = $(this).attr('href') || "{{ route('siswa.index') }}?sort_by=" + $(this).data(
                    'sort') + "&sort_type=" + ($(this).data('sort-type') || 'asc');
                fetchData(url);
                $('input[name="search"]').val('');
            });


            // Modal Tambah: Reset form & tampilkan modal
            $('#add-btn').click(function() {
                $('#siswaModalLabel').text('Tambah Siswa');
                $('#siswaForm')[0].reset();
                $('#id').val('');
                $('#method_field').html('');
                $('#siswaModal').modal('show');
            });

            // Submit form tambah/edit via AJAX
            $('#siswaForm').submit(function(e) {
                e.preventDefault();
                let id = $('#id').val();
                let url = id ? "/siswa/" + id : "/siswa";
                let method = id ? "PUT" : "POST";
                let formData = {
                    nisn: $('#nisn').val(),
                    nama: $('#nama').val(),
                    tgl_lahir: $('#tgl_lahir').val(),
                    jenis_kelamin: $('#jenis_kelamin').val(),
                    alamat: $('#alamat').val(),
                    id_kota: $('#id_kota').val(),
                    _token: "{{ csrf_token() }}"
                };

                $.ajax({
                    url: url,
                    type: method,
                    data: formData,
                    success: function(response) {
                        $('#siswaModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: id ? 'Data berhasil diperbarui!' :
                                'Data berhasil ditambahkan!',
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {
                            fetchData("{{ route('siswa.index') }}");
                        });
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors;
                        let errorMsg = '';
                        $.each(errors, function(key, value) {
                            errorMsg += value + "\n";
                        });
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: errorMsg
                        });
                    }
                });
            });

            // Tombol Edit: Isi form dengan data yang ada
            $(document).on('click', '.edit-btn', function() {
                $('#siswaModalLabel').text('Edit Siswa');
                $('#id').val($(this).data('id'));
                $('#nisn').val($(this).data('nisn'));
                $('#nama').val($(this).data('nama'));
                $('#tgl_lahir').val($(this).data('tgl_lahir'));
                $('#jenis_kelamin').val($(this).data('jenis_kelamin'));
                $('#alamat').val($(this).data('alamat'));
                $('#id_kota').val($(this).data('id_kota'));
                // Untuk edit, jika perlu tambahkan field method spoofing
                $('#method_field').html('<input type="hidden" name="_method" value="PUT">');
                $('#siswaModal').modal('show');
            });

            // Tombol Detail: Tampilkan modal detail dengan data siswa
            $(document).on('click', '.show-btn', function() {
                let id = $(this).data('id');
                $.ajax({
                    url: "/siswa/" + id,
                    type: "GET",
                    success: function(response) {
                        $('#detail-id').text(response.id);
                        $('#detail-nisn').text(response.nisn);
                        $('#detail-nama').text(response.nama);
                        $('#detail-tgl_lahir').text(response.tgl_lahir);
                        $('#detail-jenis_kelamin').text(response.jenis_kelamin);
                        $('#detail-alamat').text(response.alamat);
                        $('#detail-kota').text(response.kota ? response.kota
                            .nama_kota : '-');
                        $('#showModal').modal('show');
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Data tidak ditemukan'
                        });
                    }
                });
            });

            // Tombol Hapus: Konfirmasi dan hapus data via AJAX
            $(document).on('click', '.delete-btn', function() {
                let id = $(this).data('id');
                Swal.fire({
                    title: 'Apakah kamu yakin?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "/siswa/" + id,
                            type: "DELETE",
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Terhapus!',
                                    text: response.success,
                                    showConfirmButton: false,
                                    timer: 2000
                                }).then(() => {
                                    fetchData(
                                        "{{ route('siswa.index') }}"
                                    );
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Terjadi kesalahan saat menghapus data'
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
