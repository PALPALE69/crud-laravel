<?php
namespace App\Http\Controllers;
use App\Models\Dosen;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
    $dosenWithMatkul = Dosen::withCount('mataKuliah')->having('mata_kuliah_count', '>', 0)->get();
    $labels = $dosenWithMatkul->pluck('nama')->toArray();
    $data = $dosenWithMatkul->pluck('mata_kuliah_count')->toArray();
        return view('dashboard', compact('labels', 'data'));
    }
}
