<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\MataKuliah;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil dosen dengan jumlah mata kuliah mereka
        $dosenWithMatkul = Dosen::withCount('mataKuliah')
            ->having('mata_kuliah_count', '>', 0)
            ->orderBy('mata_kuliah_count', 'desc')
            ->get();
        
        // Prepare data untuk chart
        $labels = $dosenWithMatkul->pluck('nama')->toArray();
        $data = $dosenWithMatkul->pluck('mata_kuliah_count')->toArray();
        
        // Data statistik tambahan
        $totalDosen = Dosen::count();
        $totalMataKuliah = MataKuliah::count();
        $totalMahasiswa = Mahasiswa::count();
        $avgMataKuliahPerDosen = $totalDosen > 0 ? round($totalMataKuliah / $totalDosen, 2) : 0;
        
        // Dosen dengan mata kuliah terbanyak dan tersedikit
        $dosenTerbanyak = $dosenWithMatkul->first();
        $dosenTersedikit = $dosenWithMatkul->last();
        
        return view('dashboard', compact(
            'labels', 
            'data', 
            'totalDosen', 
            'totalMataKuliah', 
            'totalMahasiswa',
            'avgMataKuliahPerDosen',
            'dosenTerbanyak',
            'dosenTersedikit'
        ));
    }
}
