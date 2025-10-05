<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use Illuminate\Http\Request;

class DosenController extends Controller
{
public function index(Request $request){
    $q = $request->query('q');
    $items = Dosen::query()
        ->when($q, function ($query) use ($q) {
            $query->where(function ($sub) use ($q) {
                $sub->where('nama', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            });
        })
        ->latest()
        ->paginate(10)
        ->withQueryString();

    $matakuliahElektro = \App\Models\MataKuliah::where('nama_mk', 'like', '%elektro%')->get();
    return view('dosen.index', compact('items','q','matakuliahElektro'));
    }

    public function create()
    {
        return view('dosen.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nip' => 'nullable|string|unique:dosens,nip',
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:dosens,email',
            'no_telepon' => 'nullable|string',
            'mata_kuliah' => 'nullable|array',
            'mata_kuliah.*' => 'exists:mata_kuliahs,id'
        ]);

        try {
            // Create dosen tanpa mata_kuliah field
            $dosen = Dosen::create(collect($data)->except(['mata_kuliah'])->toArray());
            
            // Assign mata kuliah yang dipilih ke dosen ini
            if ($request->has('mata_kuliah') && !empty($request->mata_kuliah)) {
                \App\Models\MataKuliah::whereIn('id', $request->mata_kuliah)
                    ->update(['dosen_id' => $dosen->id]);
            }
            
            return redirect()->route('dosen.index')->with('success','Dosen berhasil dibuat.');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan dosen: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(Dosen $dosen)
    {
        return view('dosen.edit', compact('dosen'));
    }

    public function update(Request $request, Dosen $dosen)
    {
        $data = $request->validate([
            'nip' => 'nullable|string|unique:dosens,nip,'.$dosen->id,
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:dosens,email,'.$dosen->id,
            'no_telepon' => 'nullable|string',
            'mata_kuliah' => 'nullable|array',
            'mata_kuliah.*' => 'exists:mata_kuliahs,id'
        ]);

        // Update data dosen
        $dosen->update(collect($data)->except(['mata_kuliah'])->toArray());
        
        try {
            // Reset mata kuliah lama yang diajar oleh dosen ini
            \App\Models\MataKuliah::where('dosen_id', $dosen->id)
                ->update(['dosen_id' => null]);
            
            // Assign mata kuliah yang dipilih ke dosen ini
            if ($request->has('mata_kuliah') && !empty($request->mata_kuliah)) {
                \App\Models\MataKuliah::whereIn('id', $request->mata_kuliah)
                    ->update(['dosen_id' => $dosen->id]);
            }
            
            return redirect()->route('dosen.index')->with('success','Dosen berhasil diubah.');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengupdate mata kuliah: ' . $e->getMessage());
        }
    }


    public function destroy(Dosen $dosen)
    {
       $dosen->delete();
        return back()->with('ok','Dosen berhasil dihapus.');
    }
}
