<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KotaModel;
use Yajra\DataTables\Facades\DataTables;

class KotaController extends Controller
{
    public function index(Request $request)
    {
        $data = KotaModel::all();
        return view('kota', compact('data'));
    }

    // method untuk mengambil data dari database melalui Ajax
    public function getDataTable(Request $request)
    {
        if ($request->ajax()) {
            $data = KotaModel::select(['id','nama_kota'])->get();

            return DataTables::of($data)
                ->addColumn('aksi', function ($row) {
                    return '
                    <button class="btn btn-info btn-sm show-btn" data-id="' . $row->id . '">Show</button>
                    <button class="btn btn-warning btn-sm edit-btn" data-id="' . $row->id . '" data-nama="' . $row->nama_kota . '">Edit</button>
                    <button class="btn btn-danger btn-sm delete-btn" data-id="' . $row->id . '">Hapus</button>
                ';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        $request->validate(['nama_kota' => 'required']);
        KotaModel::create(['nama_kota' => $request->nama_kota]);
        return response()->json(['success' => 'Data kota berhasil ditambahkan!']);
    }

    public function show($id)
    {
        $kota = KotaModel::find($id);
        if ($kota) {
            return response()->json($kota);
        }
        return response()->json(['error' => 'Data tidak ditemukan'], 404);
    }

    public function update(Request $request, $id)
    {
        $request->validate(['nama_kota' => 'required']);
        KotaModel::where('id', $id)->update(['nama_kota' => $request->nama_kota]);
        return response()->json(['success' => 'Data kota berhasil diperbarui!']);
    }

    public function destroy($id)
    {
        KotaModel::destroy($id);
        return response()->json(['success' => 'Data kota berhasil dihapus!']);
    }
}
