<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');
        $items = Mahasiswa::query()
            ->when($q, function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('nama', 'like', "%{$q}%")
                        ->orWhere('nim', 'like', "%{$q}%")
                        ->orWhere('email', 'like', "%{$q}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('mahasiswa.index', compact('items', 'q'));
    }

    public function create()
    {
        return view('mahasiswa.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:100',
            'nim' => 'required|string|max:20|unique:mahasiswas,nim',
            'email' => 'required|email|unique:mahasiswas,email',
        ]);
        Mahasiswa::create($data);
        return redirect()->route('mahasiswa.index')->with('ok','Mahasiswa berhasil dibuat.');
    }

    public function edit(Mahasiswa $mahasiswa)
    {
        return view('mahasiswa.edit', compact('mahasiswa'));
    }

    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:100',
            'nim' => 'required|string|max:20|unique:mahasiswas,nim,'.$mahasiswa->id,
            'email' => 'required|email|unique:mahasiswas,email,'.$mahasiswa->id,
        ]);
        $mahasiswa->update($data);
        return redirect()->route('mahasiswa.index')->with('ok','Mahasiswa berhasil diubah.');
    }

    public function destroy(Mahasiswa $mahasiswa)
    {
        $mahasiswa->delete();
        return redirect()->route('mahasiswa.index')->with('ok','Mahasiswa berhasil dihapus.');
    }
}
