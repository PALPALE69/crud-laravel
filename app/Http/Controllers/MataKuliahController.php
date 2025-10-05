<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use App\Models\Dosen;
use Illuminate\Http\Request;

class MataKuliahController extends Controller
{

    public function index(Request $request)
    {
        $q = $request->query('q');
        
        $items = MataKuliah::with('dosen')
            ->when($q, function($query) use ($q) {
                $query->where('kode_mk', 'like', "%{$q}%")
                      ->orWhere('nama_mk', 'like', "%{$q}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('mata_kuliah.index', compact('items', 'q'));
    }

    public function create()
    {
        $dosens = Dosen::orderBy('nama')->get(['id','nama']);
        return view('mata_kuliah.create', compact('dosens'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kode_mk'  => 'required|string|max:10|unique:mata_kuliahs,kode_mk',
            'nama_mk'  => 'required|string|max:100',
            'sks'      => 'required|integer|min:1|max:6',
            'dosen_id' => 'nullable|exists:dosens,id',
        ]);

        MataKuliah::create($data);
        return redirect()->route('mata_kuliah.index')->with('success','Mata kuliah berhasil dibuat.');
    }

    public function  edit(MataKuliah $mata_kuliah)
    {
        $dosens = Dosen::orderBy('nama')->get(['id','nama']);
        return view('mata_kuliah.edit', compact('mata_kuliah','dosens'));
    }

    public function update(Request $request, MataKuliah $mata_kuliah)
    {
        $data = $request->validate([
            'kode_mk'  => 'required|string|max:10|unique:mata_kuliahs,kode_mk,'.$mata_kuliah->id,
            'nama_mk'  => 'required|string|max:100',
            'sks'      => 'required|integer|min:1|max:6',
            'dosen_id' => 'nullable|exists:dosens,id',
        ]);

        $mata_kuliah->update($data);
        return redirect()->route('mata_kuliah.index')->with('success','Mata kuliah berhasil diubah.');
    }

    public function destroy(MataKuliah $mata_kuliah)
    {
        $mata_kuliah->delete();
        return back()->with('success','Mata kuliah berhasil dihapus.');
    }
}
