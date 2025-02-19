<?php

namespace App\Http\Controllers;

use App\Models\SiswaModel;
use App\Models\KotaModel;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $kota = KotaModel::all();
        $siswaQuery = SiswaModel::with('kota');

        // Sorting
        if ($request->has('sort_by')) {
            $sortBy = $request->input('sort_by');
            $order  = $request->input('order', 'asc');
            $siswaQuery->orderBy($sortBy, $order);
        } else {
            $siswaQuery->orderBy('id', 'asc');
        }

        // Filtering/Pencarian
        if ($request->has('search')) {
            $search = $request->input('search');
            $siswaQuery->where(function ($query) use ($search) {
                $query->where('nama', 'like', '%' . $search . '%')
                    ->orWhere('nisn', 'like', '%' . $search . '%')
                    ->orWhere('alamat', 'like', '%' . $search . '%');
            });
        }

        $siswa = $siswaQuery->paginate(5);

        // Jika request AJAX (misalnya untuk search, sort, pagination)
        if ($request->ajax()) {
            return view('siswa.table', compact('siswa'))->render();
        }

        // Simpan search query di session
        session(['search_query' => $request->input('search')]);

        return view('siswa.index', compact('kota', 'siswa'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nisn'          => 'required',
            'nama'          => 'required',
            'tgl_lahir'     => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat'        => 'required|string',
            'id_kota'       => 'required|exists:tb_kota,id',
        ]);

        SiswaModel::create([
            'nisn'          => $request->nisn,
            'nama'          => $request->nama,
            'tgl_lahir'     => $request->tgl_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat'        => $request->alamat,
            'id_kota'       => $request->id_kota,
        ]);

        // Kembalikan response JSON untuk AJAX
        return response()->json(['success' => 'Data siswa berhasil ditambahkan!']);
    }

    public function show($id)
    {
        $siswa = SiswaModel::with('kota')->find($id);
        if ($siswa) {
            // Untuk modal detail, bisa kembalikan response JSON
            return response()->json($siswa);
        }
        return response()->json(['error' => 'Data tidak ditemukan!'], 404);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nisn'          => 'required',
            'nama'          => 'required',
            'tgl_lahir'     => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat'        => 'required|string',
            'id_kota'       => 'required|exists:tb_kota,id',
        ]);

        SiswaModel::where('id', $id)->update([
            'nisn'          => $request->nisn,
            'nama'          => $request->nama,
            'tgl_lahir'     => $request->tgl_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat'        => $request->alamat,
            'id_kota'       => $request->id_kota,
        ]);

        // Kembalikan response JSON untuk AJAX
        return response()->json(['success' => 'Data siswa berhasil diperbarui!']);
    }

    public function destroy($id)
    {
        SiswaModel::destroy($id);
        // Kembalikan response JSON untuk AJAX
        return response()->json(['success' => 'Data siswa berhasil dihapus!']);
    }
}
