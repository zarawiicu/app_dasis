<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiswaModel;
use App\Models\KotaModel;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    public function index()
    {
        // Hitung total siswa
        $totalSiswa = SiswaModel::count();

        // Hitung siswa berdasarkan jenis kelamin
        $totalPerempuan = SiswaModel::where('jenis_kelamin', 'P')->count();
        $totalLaki = SiswaModel::where('jenis_kelamin', 'L')->count();

        // Data untuk diagram donat (jenis kelamin)
        $jenisKelaminData = [
            'labels' => ['Laki-laki', 'Perempuan'],
            'data' => [$totalLaki, $totalPerempuan]
        ];

        // Data untuk diagram bulat (jumlah siswa berdasarkan kota)
        $kotaData = SiswaModel::select('id_kota', DB::raw('count(*) as total'))
            ->groupBy('id_kota')
            ->with('kota')
            ->get()
            ->map(function ($item) {
                return [
                    'label' => $item->kota->nama_kota ?? 'Tidak Diketahui',
                    'total' => $item->total
                ];
            });

        // Data untuk diagram batang (jumlah siswa berdasarkan tahun lahir)
        $tahunData = SiswaModel::select(DB::raw("YEAR(tgl_lahir) as tahun"), DB::raw("count(*) as total"))
            ->groupBy('tahun')
            ->orderBy('tahun', 'asc')
            ->get();

        return view('dashboard', compact(
            'totalSiswa',
            'totalPerempuan',
            'totalLaki',
            'jenisKelaminData',
            'kotaData',
            'tahunData'
        ));
    }
}
?>