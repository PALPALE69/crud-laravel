<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use App\Models\Dosen;
use Illuminate\Http\Request;

class MataKuliahController extends Controller
{

    public function index(Request $request)
    {
        $q        = $request->query('q');
        $dosen_id = $request->query('dosen_id');
        
        $items = MataKuliah::with('dosen')
            ->when($q, fn($qr) => $qr->where('nama','like',"%{$q}%"))
            ->when($dosen_id, fn($qr) => $qr->where('dosen_id',$dosen_id))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $dosens = Dosen::orderBy('nama')->get(['id','nama']);

        return view('mata_kuliah.index', 
    compact('items','q','dosen_id','dosens'));
    }

    public function create()
    {
        $dosens = Dosen::orderBy('nama')->get(['id','nama']);
        return view('mata_kuliah.create', compact('dosens'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama'     => 'required|string|max:100',
            'sks'      => 'required|integer|min:1|max:6',
            'dosen_id' => 'required|exists:dosens,id',
        ]);

        MataKuliah::create($data);
        return redirect()->route('mata_kuliah.index')->with('ok','Mata 
    kuliah berhasil dibuat.');
    }

    public function  edit(MataKuliah $mata_kuliah)
    {
        $dosens = Dosen::orderBy('nama')->get(['id','nama']);
        return view('mata_kuliah.edit', compact('mata_kuliah','dosens'));
    }

    public function update(Request $request, MataKuliah $mata_kuliah)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:100',
            'sks' => 'required|integer|min:1|max:6',
            'dosen_id' => 'required|exists:dosens,id',
        ]);

        $mata_kuliah->update($data);
        return redirect()->route('mata_kuliah.index')->with('ok','Mata kuliah berhasil diubah.');
    }

    public function destroy(MataKuliah $mata_kuliah)
    {
        $mata_kuliah->delete();
        return back()->with('ok','Mata kuliah berhasil dihapus.');
    }
}
