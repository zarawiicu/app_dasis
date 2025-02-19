<table class="table table-bordered">
    <thead>
        <tr>
            <th><a href="#" class="sort-link" data-sort="id">ID</a></th>
            <th><a href="#" class="sort-link" data-sort="nama_kota">Nama Kota</a></th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $kota)
        <tr>
            <td>{{ $kota->id }}</td>
            <td>{{ $kota->nama_kota }}</td>
            <td>
                <!-- Tombol Show -->
                <button class="btn btn-info show-btn" data-id="{{ $kota->id }}">Detail</button>
                <!-- Tombol Edit -->
                <button class="btn btn-warning edit-btn" data-id="{{ $kota->id }}" data-nama="{{ $kota->nama_kota }}">Edit</button>
                <!-- Tombol Hapus -->
                <button class="btn btn-danger delete-btn" data-id="{{ $kota->id }}">Hapus</button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Pagination -->
<div class="d-flex justify-content-end">
    {{ $data->links('pagination::bootstrap-4') }}
</div>

