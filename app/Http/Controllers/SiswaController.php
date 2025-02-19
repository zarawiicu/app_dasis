<?php

namespace App\Http\Controllers;

use App\Models\SiswaModel;
use App\Models\KotaModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SiswaController extends Controller
{
    public function index(Request $request)
    {   
        $kota = KotaModel::all();
        return view('siswa', compact('kota'));
    }

    // method untuk mengambil data dari database melalui Ajax
    public function getDataTable(Request $request)
    {
        if ($request->ajax()) {
            $data = SiswaModel::with('kota')->select(['id','nisn','nama','tgl_lahir','jenis_kelamin','alamat','id_kota']);
            return DataTables::of($data)
                ->addColumn('kota', function($row) {
                    return $row->kota ? $row->kota->nama_kota : '-'; // Memperbaiki akses nama kota
                })
                ->addColumn('aksi', function($row) {
                    return '
                        <button class="btn btn-info btn-sm show-btn" data-id="'. $row->id .'">Show</button>
                        <button class="btn btn-warning btn-sm edit-btn" 
                            data-id="'. $row->id .'"
                            data-nisn="'. $row->nisn .'"
                            data-nama="'. $row->nama .'"
                            data-tgl_lahir="'. $row->tgl_lahir .'"
                            data-jenis_kelamin="'. $row->jenis_kelamin .'"
                            data-alamat="'. $row->alamat .'"
                            data-id_kota="'. $row->id_kota .'"
                        >Edit</button>
                        <button class="btn btn-danger btn-sm delete-btn" data-id="'. $row->id .'">Hapus</button>
                    ';
                })
                ->rawColumn(['aksi'])
                ->make(true);
        }    
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nisn' => 'required',
            'nama' => 'required',
            'tgl_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required|string',
            'kota' => 'required|exists:tb_kota,id',
        ]);

        SiswaModel::create([
            'nisn' => $request->nisn,
            'nama' => $request->nama,
            'tgl_lahir' => $request->tgl_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'id_kota' => $request->kota,
        ]);

        return response()->json(['success' => 'Data siswa berhasil ditambahkan!']);
    }

    public function show($id)
    {
        $siswa = SiswaModel::with('kota')->find($id);
        if ($siswa) {
            return response()->json($siswa);
        }
        return response()->json(['error' => 'Data tidak ditemukan!'], 404);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nisn' => 'required',
            'nama' => 'required',
            'tgl_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required|string',
            'kota' => 'required|exists:tb_kota,id',
        ]);

        // Perbaiki penulisan metode where
        SiswaModel::where('id', $id)->update([
            'nisn' => $request->nisn,
            'nama' => $request->nama,
            'tgl_lahir' => $request->tgl_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'id_kota' => $request->kota,
        ]);

        return response()->json(['success' => 'Data siswa berhasil diperbarui!']);
    }

    public function destroy($id)
    {
        SiswaModel::destroy($id);
        return response()->json(['success' => 'Data siswa berhasil dihapus!']);
    }
}
