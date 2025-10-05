
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #388e3c; color: #fff;">
            <h4 class="mb-0"><i class="fas fa-book"></i> Daftar Mata Kuliah</h4>
            <a href="{{ route('mata_kuliah.create') }}" class="btn btn-success btn-sm rounded-pill"><i class="fas fa-plus"></i> Tambah Mata Kuliah</a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                    <thead class="table-success">
                        <tr>
                            <th style="width: 5%">No</th>
                            <th style="width: 15%">Kode MK</th>
                            <th>Nama Mata Kuliah</th>
                            <th style="width: 8%">SKS</th>
                            <th style="width: 20%">Dosen Pengampu</th>
                            <th style="width: 12%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $mk)
                        <tr>
                            <td>{{ $loop->iteration + ($items->currentPage() - 1) * $items->perPage() }}</td>
                            <td>{{ $mk->kode_mk }}</td>
                            <td>{{ $mk->nama_mk }}</td>
                            <td>{{ $mk->sks }}</td>
                            <td>{{ $mk->dosen ? $mk->dosen->nama : '-' }}</td>
                            <td>
                                <a href="{{ route('mata_kuliah.edit', $mk->id) }}" class="btn btn-warning btn-sm me-1"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('mata_kuliah.destroy', $mk->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white py-2">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    {{ $items->links() }}
                </div>
                <div>
                    <small>showing {{ $items->firstItem() }} to {{ $items->lastItem() }} of {{ $items->total() }} results</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
