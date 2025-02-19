@extends('layouts.app')

@section('title', 'Manajemen Kota')
@section('page_header', 'Daftar Kota')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <button class="btn btn-primary" id="add-btn" data-target="modal">Tambah Kota</button>
            </div>
            <div class="card-body">
                <table id="kotaTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Kota</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal untuk tambah/edit -->
    <div class="modal fade" id="kotaModal" tabindex="-1" role="dialog" aria-labelledby="kotaModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="kotaModalLabel">Tambah Kota</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="kota_id">
                    <div class="form-group">
                        <label for="nama_kota">Nama Kota</label>
                        <input type="text" class="form-control" id="nama_kota" placeholder="Masukkan nama kota">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="save-btn">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk menampilkan detail (Show) -->
    <div class="modal fade" id="showModal" tabindex="-1" role="dialog" aria-labelledby="showModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="showModalLabel">Detail Kota</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>ID: </strong><span id="detail-id"></span></p>
                    <p><strong>Nama Kota: </strong><span id="detail-nama"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#kotaTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('kota.getDataTable') }}",
                    type: 'GET',
                    dataSrc: 'data',
                    error: function(xhr, error, thrown) {
                        if (xhr.status === 500) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Terjadi kesalahan pada server',
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Terjadi kesalahan saat mengambil data',
                            });
                        }
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'nama_kota',
                        name: 'nama_kota'
                    },
                    {
                        data: 'aksi',
                        name: 'aksi'
                    }
                ],
                columnDefs: [{
                    targets: 2, // indeks kolom "aksi"
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
                }]
            });
        });

        // Tombol untuk menampilkan modal tambah
        $('#add-btn').click(function() {
            $('#kotaModalLabel').text('Tambah Kota');
            $('#kota_id').val('');
            $('#nama_kota').val('');
            $('#kotaModal').modal('show');
        });

        // Tombol untuk simpan data (tambah/edit)
        $('#save-btn').click(function() {
            let id = $('#kota_id').val();
            let url = id ? "/kota/" + id : "/kota";
            let method = id ? "PUT" : "POST";

            $.ajax({
                url: url,
                type: method,
                data: {
                    nama_kota: $('#nama_kota').val(),
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    $('#kotaModal').modal('hide');
                    kotaTable.ajax.reload();
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses',
                        text: response.success,
                        timer: 2000,
                        showConfirmButton: false
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
                        text: errorMsg,
                    });
                }
            });
        });

        // Tombol edit
        $(document).on('click', '.edit-btn', function() {
            $('#kotaModalLabel').text('Edit Kota');
            $('#kota_id').val($(this).data('id'));
            $('#nama_kota').val($(this).data('nama'));
            $('#kotaModal').modal('show');
        });

        // Tombol show (detail)
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
                        text: 'Data tidak ditemukan',
                    });
                }
            });
        });

        // Tombol hapus dengan konfirmasi SweetAlert
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
                        url: "/kota/" + id,
                        type: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            kotaTable.ajax.reload();
                            Swal.fire({
                                icon: 'success',
                                title: 'Terhapus!',
                                text: response.success,
                                timer: 2000,
                                showConfirmButton: false
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Terjadi kesalahan saat menghapus data',
                            });
                        }
                    });
                }
            });
        });
    </script>
@endpush
