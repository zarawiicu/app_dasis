<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KotaModel;

class KotaController extends Controller
{
    public function index(Request $request)
    {
        $query = KotaModel::query();

        // Search
        if ($request->has('search')) {
            $query->where('nama_kota', 'LIKE', "%{$request->search}%");
        }

        // Sorting
        if ($request->has('sort_by') && in_array($request->sort_by, ['id', 'nama_kota'])) {
            $sortType = $request->sort_type == 'desc' ? 'desc' : 'asc';
            $query->orderBy($request->sort_by, $sortType);
        } else {
            $query->orderBy('id', 'asc');
        }

        $data = $query->paginate(5);

        if ($request->ajax()) {
            return view('kota.table', compact('data'))->render();
        }

        return view('kota.index', compact('data'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama_kota' => 'required'
        ]);

        KotaModel::create([
            'nama_kota' => $request->nama_kota
        ]);

        return redirect()->route('kota.index')->with('success', 'Data kota berhasil ditambahkan!');
    }

    public function show($id)
    {
        $kota = KotaModel::find($id);
        if ($kota) {
            return response()->json($kota);
        }
        return response()->json(['error' => 'Data tidak ditemukan'], 404);
    }

    public function edit($id)
    {
        $kota = KotaModel::find($id);
        return response()->json($kota);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kota' => 'required'
        ]);

        KotaModel::where('id', $id)->update([
            'nama_kota' => $request->nama_kota
        ]);

        return redirect()->route('kota.index')->with('success', 'Data kota berhasil diperbarui!');
    }

    public function destroy($id)
    {
        KotaModel::destroy($id);
        return redirect()->route('kota.index')->with('success', 'Data kota berhasil dihapus!');
    }
}
