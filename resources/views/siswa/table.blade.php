<table class="table table-bordered">
    <thead>
        <tr>
            <th>
                <a href="{{ route('siswa.index', ['sort_by' => 'id', 'order' => request('order') === 'asc' ? 'desc' : 'asc']) }}" class="sort-link" data-sort="id" data-order="{{ request('order') }}">
                    ID
                </a>
            </th>
            <th>
                <a href="{{ route('siswa.index', ['sort_by' => 'nisn', 'order' => request('order') === 'asc' ? 'desc' : 'asc']) }}" class="sort-link" data-sort="nisn" data-order="{{ request('order') }}">
                    NISN
                </a>
            </th>
            <th>
                <a href="{{ route('siswa.index', ['sort_by' => 'nama', 'order' => request('order') === 'asc' ? 'desc' : 'asc']) }}" class="sort-link" data-sort="nama" data-order="{{ request('order') }}">
                    Nama
                </a>
            </th>
            <th>
                <a href="{{ route('siswa.index', ['sort_by' => 'tgl_lahir', 'order' => request('order') === 'asc' ? 'desc' : 'asc']) }}" class="sort-link" data-sort="tgl_lahir" data-order="{{ request('order') }}">
                    Tgl Lahir
                </a>
            </th>
            <th>
                <a href="{{ route('siswa.index', ['sort_by' => 'jenis_kelamin', 'order' => request('order') === 'asc' ? 'desc' : 'asc']) }}" class="sort-link" data-sort="jenis_kelamin" data-order="{{ request('order') }}">
                    Jenis Kelamin
                </a>
            </th>
            <th>Alamat</th>
            <th>Kota</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @if($siswa->count())
            @foreach($siswa as $s)
            <tr>
                <td>{{ $s->id }}</td>
                <td>{{ $s->nisn }}</td>
                <td>{{ $s->nama }}</td>
                <td>{{ $s->tgl_lahir }}</td>
                <td>{{ $s->jenis_kelamin }}</td>
                <td>{{ $s->alamat }}</td>
                <td>{{ $s->kota ? $s->kota->nama_kota : '-' }}</td>
                <td class="text-center">
                    <button class="btn btn-info show-btn" data-id="{{ $s->id }}">Detail</button>
                    <button class="btn btn-warning edit-btn" 
                        data-id="{{ $s->id }}"
                        data-nisn="{{ $s->nisn }}"
                        data-nama="{{ $s->nama }}"
                        data-tgl_lahir="{{ $s->tgl_lahir }}"
                        data-jenis_kelamin="{{ $s->jenis_kelamin }}"
                        data-alamat="{{ $s->alamat }}"
                        data-id_kota="{{ $s->id_kota }}"
                    >Edit</button>
                    <button class="btn btn-danger delete-btn" data-id="{{ $s->id }}">Hapus</button>
                </td>
            </tr>
            @endforeach
        @else
            <tr>
                <td colspan="8" class="text-center">Data tidak ditemukan</td>
            </tr>
        @endif
    </tbody>
</table>

<!-- Pagination -->
<div class="d-flex justify-content-end">
    {{ $siswa->links('pagination::bootstrap-4') }}
</div>

