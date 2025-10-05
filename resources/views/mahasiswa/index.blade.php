@extends('layouts.app')
@section('content')
<h1>Daftar Mahasiswa</h1>
<a href="{{ route('mahasiswa.create') }}" class="btn btn-primary mb-3">Tambah Mahasiswa</a>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>NIM</th>
            <th>Email</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($mahasiswa as $item)
        <tr>
            <td>{{ $loop->iteration + ($mahasiswa->currentPage()-1)*$mahasiswa->perPage() }}</td>
            <td>{{ $item->nama }}</td>
            <td>{{ $item->nim }}</td>
            <td>{{ $item->email }}</td>
            <td>
                <a href="{{ route('mahasiswa.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('mahasiswa.destroy', $item->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="text-center">Tidak ada data mahasiswa</td>
        </tr>
        @endforelse
    </tbody>
</table>
<div class="d-flex justify-content-center">
    {{ $mahasiswa->links() }}
</div>
@endsection