
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #388e3c; color: #fff;">
            <h4 class="mb-0"><i class="fas fa-book"></i> Daftar Mata Kuliah</h4>
            <a href="{{ route('mata_kuliah.create') }}" class="btn btn-light btn-sm rounded-pill">
                <i class="fas fa-plus"></i> Tambah Mata Kuliah
            </a>
        </div>
        <div class="card-body">
            <!-- Search Form -->
            <form action="{{ route('mata_kuliah.index') }}" method="GET" class="mb-4">
                <div class="row">
                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" name="q" class="form-control" placeholder="Cari mata kuliah berdasarkan kode atau nama..." value="{{ request('q') }}">
                            <button class="btn btn-success" type="submit">Cari</button>
                            @if(request('q'))
                            <a href="{{ route('mata_kuliah.index') }}" class="btn btn-outline-secondary">Reset</a>
                            @endif
                        </div>
                    </div>
                </div>
            </form>

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if($items->count() > 0)
            <!-- Data Table -->
            <div class="table-responsive">
                <table class="table table-hover mb-0">
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
                            <td><span class="badge bg-primary">{{ $mk->kode_mk }}</span></td>
                            <td><strong>{{ $mk->nama_mk }}</strong></td>
                            <td><span class="badge bg-info">{{ $mk->sks }}</span></td>
                            <td>
                                @if($mk->dosen)
                                    <i class="fas fa-user-tie text-muted me-1"></i>
                                    {{ $mk->dosen->nama }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('mata_kuliah.edit', $mk->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm" title="Hapus" 
                                            onclick="confirmDelete('{{ $mk->id }}', '{{ $mk->nama_mk }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                <form id="delete-form-{{ $mk->id }}" action="{{ route('mata_kuliah.destroy', $mk->id) }}" 
                                      method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <!-- Empty State -->
            <div class="text-center py-5">
                <i class="fas fa-book fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Tidak ada data mata kuliah</h5>
                <p class="text-muted">Silakan tambahkan mata kuliah baru dengan mengklik tombol "Tambah Mata Kuliah" di atas.</p>
                <a href="{{ route('mata_kuliah.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Tambah Mata Kuliah Pertama
                </a>
            </div>
            @endif
        </div>

        @if($items->count() > 0)
        <div class="card-footer bg-white py-2">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    {{ $items->links() }}
                </div>
                <div>
                    <small class="text-muted">
                        Menampilkan {{ $items->firstItem() }} sampai {{ $items->lastItem() }} 
                        dari {{ $items->total() }} hasil
                    </small>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-exclamation-triangle text-warning"></i> Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus mata kuliah <strong id="mkName"></strong>?</p>
                <p class="text-danger"><small><i class="fas fa-info-circle"></i> Tindakan ini tidak dapat dibatalkan.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Hapus</button>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(id, nama) {
    document.getElementById('mkName').textContent = nama;
    document.getElementById('confirmDelete').onclick = function() {
        document.getElementById('delete-form-' + id).submit();
    };
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>
@endsection
