@extends('layouts.app')
@section('title', 'Daftar Mahasiswa')
@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">
            <i class="fas fa-user-graduate me-2"></i>Daftar Mahasiswa
        </h1>
        <a href="{{ route('mahasiswa.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i>Tambah Mahasiswa
        </a>
    </div>

    <!-- Alert Messages -->
    @if(session('ok'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('ok') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Search Form -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('mahasiswa.index') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-6">
                        <label for="q" class="form-label">
                            <i class="fas fa-search me-1"></i>Pencarian
                        </label>
                        <input type="text" 
                               class="form-control" 
                               id="q" 
                               name="q" 
                               value="{{ $q }}"
                               placeholder="Cari berdasarkan nama, NIM, atau email...">
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-1"></i>Cari
                            </button>
                            @if($q)
                                <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times me-1"></i>Reset
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card shadow">
        <div class="card-header bg-light">
            <h5 class="mb-0">
                <i class="fas fa-table me-2"></i>Data Mahasiswa 
                <span class="badge bg-primary ms-2">{{ $items->total() }} Total</span>
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th width="5%">No</th>
                            <th width="25%">
                                <i class="fas fa-user me-1"></i>Nama
                            </th>
                            <th width="20%">
                                <i class="fas fa-id-badge me-1"></i>NIM
                            </th>
                            <th width="30%">
                                <i class="fas fa-envelope me-1"></i>Email
                            </th>
                            <th width="20%" class="text-center">
                                <i class="fas fa-cogs me-1"></i>Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($items as $item)
                        <tr>
                            <td class="fw-bold">
                                {{ $loop->iteration + ($items->currentPage()-1) * $items->perPage() }}
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle bg-primary text-white me-2">
                                        {{ strtoupper(substr($item->nama, 0, 1)) }}
                                    </div>
                                    <strong>{{ $item->nama }}</strong>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $item->nim }}</span>
                            </td>
                            <td>
                                <i class="fas fa-envelope text-muted me-1"></i>
                                <a href="mailto:{{ $item->email }}" class="text-decoration-none">
                                    {{ $item->email }}
                                </a>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('mahasiswa.edit', $item->id) }}" 
                                       class="btn btn-warning btn-sm" 
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-danger btn-sm" 
                                            onclick="confirmDelete({{ $item->id }}, '{{ $item->nama }}')"
                                            title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                
                                <!-- Form Delete (Hidden) -->
                                <form id="delete-form-{{ $item->id }}" 
                                      action="{{ route('mahasiswa.destroy', $item->id) }}" 
                                      method="POST" 
                                      style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-users fa-3x mb-3"></i>
                                    <h5>Tidak ada data mahasiswa</h5>
                                    <p>{{ $q ? 'Tidak ditemukan mahasiswa dengan kriteria pencarian tersebut.' : 'Belum ada mahasiswa yang terdaftar.' }}</p>
                                    @if(!$q)
                                        <a href="{{ route('mahasiswa.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus me-1"></i>Tambah Mahasiswa Pertama
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        @if($items->hasPages())
        <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Menampilkan {{ $items->firstItem() ?? 0 }} hingga {{ $items->lastItem() ?? 0 }} 
                    dari {{ $items->total() }} hasil
                </div>
                {{ $items->links() }}
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Custom Styles -->
<style>
.avatar-circle {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 14px;
}

.btn-group .btn {
    border-radius: 0.375rem !important;
    margin-right: 2px;
}
</style>

<!-- Delete Confirmation Script -->
<script>
function confirmDelete(id, nama) {
    if (confirm('Apakah Anda yakin ingin menghapus mahasiswa "' + nama + '"?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endsection