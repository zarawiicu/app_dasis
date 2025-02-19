@extends('layouts.app')

@section('title', 'Manajemen Siswa')
@section('page_header', 'Daftar Siswa')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <button class="btn btn-primary" id="add-btn" data-target="modal">Tambah Siswa</button>
            </div>
            <div class="card-body">
                <table id="siswaTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NISN</th>
                            <th>Nama</th>
                            <th>Tgl Lahir</th>
                            <th>Jenis Kelamin</th>
                            <th>Alamat</th>
                            <th>Kota</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal untuk tambah/edit siswa -->
    <div class="modal fade" id="siswaModal" tabindex="-1" role="dialog" aria-labelledby="siswaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="siswaModalLabel">Tambah Siswa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id">
                    <div class="form-group">
                        <label for="nisn">NISN</label>
                        <input type="text" class="form-control" id="nisn" placeholder="Masukkan NISN">
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" placeholder="Masukkan nama">
                    </div>
                    <div class="form-group">
                        <label for="tgl_lahir">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="tgl_lahir">
                    </div>
                    <div class="form-group">
                        <label for="jenis_kelamin">Jenis Kelamin</label>
                        <select class="form-control" id="jenis_kelamin">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control" id="alamat" placeholder="Masukkan alamat"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="id_kota">Kota</label>
                        <select class="form-control" id="id_kota">
                            <option value="">Pilih Kota</option>
                            @foreach ($kota as $k)
                                <option value="{{ $k->id }}">{{ $k->nama_kota }}</option>
                            @endforeach
                        </select>
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
                    <h5 class="modal-title" id="showModalLabel">Detail Siswa</h5>
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
    var siswaTable = $('#siswaTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('siswa.getDataTable') }}",
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
                data: 'nisn',
                name: 'nisn'
            },
            {
                data: 'nama',
                name: 'nama'
            },
            {
                data: 'tgl_lahir',
                name: 'tgl_lahir'
            },
            {
                data: 'jenis_kelamin',
                name: 'jenis_kelamin'
            },
            {
                data: 'alamat',
                name: 'alamat'
            },
            {
                data: 'kota',
                name: 'kota'
            },
            {
                data: 'aksi',
                name: 'aksi',
                orderable: false,
                searchable: false
            },
        ],
        columnDefs: [{
            targets: 7, // indeks kolom "aksi"
            orderable: false,
            searchable: false,
            className: 'text-center'
        }]
    });
});
        // Menampilkan modal tambah data
$('#add-btn').click(function() {
    $('#siswaModalLabel').text('Tambah Siswa');
    $('#id').val('');
    $('#nisn').val('');
    $('#nama').val('');
    $('#tgl_lahir').val('');
    $('#jenis_kelamin').val('');
    $('#alamat').val('');
    $('#id_kota').val('');
    $('#siswaModal').modal('show');
});

// Simpan data (tambah/edit)
$('#save-btn').click(function() {
    let id = $('#id').val();
    let url = id ? "/siswa/" + id : "/siswa";
    let method = id ? "PUT" : "POST";

    $.ajax({
        url: url,
        type: method,
        data: {
            nisn: $('#nisn').val(),
            nama: $('#nama').val(),
            tgl_lahir: $('#tgl_lahir').val(),
            jenis_kelamin: $('#jenis_kelamin').val(),
            alamat: $('#alamat').val(),
            id_kota: $('#id_kota').val(),
            _token: "{{ csrf_token() }}"
        },
        success: function(response) {
            $('#siswaModal').modal('hide');
            siswaTable.ajax.reload();
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
            let errMsg = '';
            $.each(errors, function(key, value) {
                errMsg += value + "\n";
            });

            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: errMsg,
            });
        }
    });
});

// Tombol Edit
$(document).on('click', '.edit-btn', function() {
    $('#siswaModalLabel').text('Edit Siswa');
    $('#id').val($(this).data('id'));
    $('#nisn').val($(this).data('nisn'));
    $('#nama').val($(this).data('nama'));
    $('#tgl_lahir').val($(this).data('tgl_lahir'));
    $('#jenis_kelamin').val($(this).data('jenis_kelamin'));
    $('#alamat').val($(this).data('alamat'));
    $('#id_kota').val($(this).data('id_kota'));
    $('#siswaModal').modal('show');
});

// Tombol Show (Detail)
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
            $('#detail-kota').text(response.kota ? response.kota.nama_kota : '-');
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

// Tombol Hapus dengan konfirmasi SweetAlert
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
                    siswaTable.ajax.reload();
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
    </script>
@endpush
