@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Daftar Dosen</h1>
    <a href="{{ route('dosen.create') }}" class="btn btn-primary mb-3">Tambah Dosen</a>
    <form action="{{ route('dosen.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Cari dosen by nama/email" value="{{ request('q') }}">
            <button class="btn btn-outline-secondary" type="submit">Cari</button>
        </div>
    </form>
    <table class="table table-bordered text-center align-middle">
        <thead>
            <tr>
                <th style="width:5%">No</th>
                <th style="width:18%">NIP</th>
                <th style="width:18%">Nama</th>
                <th style="width:22%">Email</th>
                <th style="width:15%">No Telepon</th>
                <th style="width:20%">Mata Kuliah Diampu</th>
                <th style="width:12%">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($items as $item)
            <tr>
                <td>{{ $loop->iteration + ($items->currentPage()-1)*$items->perPage() }}</td>
                <td><span style="font-family:'Press Start 2P',cursive;font-size:0.9rem;">{{ $item->nip }}</span></td>
                <td><b>{{ $item->nama }}</b></td>
                <td>{{ $item->email }}</td>
                <td><span style="font-family:'Montserrat',Arial;font-size:0.95rem;">{{ $item->no_telepon }}</span></td>
                <td>
                    @if($item->mataKuliah && count($item->mataKuliah))
                    <table class="table table-sm table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>Kode MK</th>
                                <th>Nama MK</th>
                                <th>SKS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($item->mataKuliah as $mk)
                            <tr>
                                <td>{{ $mk->kode_mk }}</td>
                                <td>{{ $mk->nama_mk }}</td>
                                <td>{{ $mk->sks }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('dosen.edit', $item->id) }}" class="btn btn-warning btn-sm me-1" title="Edit"><span style="font-size:1.2em;">✏️</span></a>
                    <form action="{{ route('dosen.destroy', $item->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('Yakin ingin menghapus dosen ini?')"><span style="font-size:1.2em;">🗑️</span></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Tidak ada data dosen</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="d-flex justify-content-center">
        {{ $items->links() }}
    </div>
</div>

<div class="container mt-5">
    <h2 class="mb-3">Daftar Mata Kuliah Elektro</h2>
    <table class="table table-bordered text-center align-middle">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode MK</th>
                <th>Nama Mata Kuliah</th>
                <th>SKS</th>
                <th>Dosen Pengampu</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($matakuliahElektro ?? [] as $mk)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $mk->kode_mk }}</td>
                <td>{{ $mk->nama_mk }}</td>
                <td>{{ $mk->sks }}</td>
                <td>{{ $mk->dosen ? $mk->dosen->nama : '-' }}</td>
            </tr>
            @endforeach
            @if (empty($matakuliahElektro) || count($matakuliahElektro) == 0)
            <tr>
                <td colspan="5" class="text-center">Tidak ada data mata kuliah elektro</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection
