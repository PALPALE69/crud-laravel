@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #2196f3; color: #fff;">
            <h4 class="mb-0"><i class="fas fa-chalkboard-teacher"></i> Daftar Dosen</h4>
            <a href="{{ route('dosen.create') }}" class="btn btn-light btn-sm rounded-pill">
                <i class="fas fa-plus"></i> Tambah Dosen
            </a>
        </div>
        <div class="card-body">
            <!-- Search Form -->
            <form action="{{ route('dosen.index') }}" method="GET" class="mb-4">
                <div class="row">
                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" name="q" class="form-control" placeholder="Cari dosen berdasarkan nama atau email..." value="{{ request('q') }}">
                            <button class="btn btn-primary" type="submit">Cari</button>
                            @if(request('q'))
                            <a href="{{ route('dosen.index') }}" class="btn btn-outline-secondary">Reset</a>
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
                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%">No</th>
                            <th style="width: 15%">NIP</th>
                            <th style="width: 20%">Nama</th>
                            <th style="width: 20%">Email</th>
                            <th style="width: 15%">No. Telepon</th>
                            <th style="width: 15%">Mata Kuliah</th>
                            <th style="width: 10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                        <tr>
                            <td>{{ $loop->iteration + ($items->currentPage() - 1) * $items->perPage() }}</td>
                            <td><span class="badge bg-secondary">{{ $item->nip }}</span></td>
                            <td><strong>{{ $item->nama }}</strong></td>
                            <td>
                                <i class="fas fa-envelope text-muted me-1"></i>
                                {{ $item->email }}
                            </td>
                            <td>
                                <i class="fas fa-phone text-muted me-1"></i>
                                {{ $item->no_telepon }}
                            </td>
                            <td>
                                @if($item->mataKuliah && $item->mataKuliah->count() > 0)
                                    <span class="badge bg-success">{{ $item->mataKuliah->count() }} MK</span>
                                    <button class="btn btn-sm btn-outline-info ms-1" type="button" data-bs-toggle="collapse" 
                                            data-bs-target="#collapse{{ $item->id }}" aria-expanded="false">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('dosen.edit', $item->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm" title="Hapus" 
                                            onclick="confirmDelete('{{ $item->id }}', '{{ $item->nama }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                <form id="delete-form-{{ $item->id }}" action="{{ route('dosen.destroy', $item->id) }}" 
                                      method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @if($item->mataKuliah && $item->mataKuliah->count() > 0)
                        <tr>
                            <td colspan="7" class="p-0">
                                <div class="collapse" id="collapse{{ $item->id }}">
                                    <div class="card card-body m-2">
                                        <h6 class="mb-2"><i class="fas fa-book text-primary"></i> Mata Kuliah yang Diampu:</h6>
                                        <div class="table-responsive">
                                            <table class="table table-sm table-bordered mb-0">
                                                <thead class="table-primary">
                                                    <tr>
                                                        <th>Kode MK</th>
                                                        <th>Nama MK</th>
                                                        <th>SKS</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($item->mataKuliah as $mk)
                                                    <tr>
                                                        <td><strong>{{ $mk->kode_mk }}</strong></td>
                                                        <td>{{ $mk->nama_mk }}</td>
                                                        <td>{{ $mk->sks }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <!-- Empty State -->
            <div class="text-center py-5">
                <i class="fas fa-chalkboard-teacher fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Tidak ada data dosen</h5>
                <p class="text-muted">Silakan tambahkan dosen baru dengan mengklik tombol "Tambah Dosen" di atas.</p>
                <a href="{{ route('dosen.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Dosen Pertama
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

    @if(isset($matakuliahElektro) && count($matakuliahElektro) > 0)
    <!-- Mata Kuliah Elektro Section -->
    <div class="card shadow-sm mt-4">
        <div class="card-header" style="background-color: #4caf50; color: #fff;">
            <h5 class="mb-0"><i class="fas fa-microchip"></i> Daftar Mata Kuliah Elektro</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead class="table-success">
                        <tr>
                            <th style="width: 8%">No</th>
                            <th style="width: 15%">Kode MK</th>
                            <th>Nama Mata Kuliah</th>
                            <th style="width: 10%">SKS</th>
                            <th style="width: 25%">Dosen Pengampu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @foreach ($matakuliahElektro as $mk)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td><span class="badge bg-primary">{{ $mk->kode_mk }}</span></td>
                            <td>{{ $mk->nama_mk }}</td>
                            <td><span class="badge bg-info">{{ $mk->sks }}</span></td>
                            <td>
                                @if($mk->dosen)
                                    <i class="fas fa-user-tie text-muted me-1"></i>
                                    {{ $mk->dosen->nama }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
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
                <p>Apakah Anda yakin ingin menghapus dosen <strong id="dosenName"></strong>?</p>
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
    document.getElementById('dosenName').textContent = nama;
    document.getElementById('confirmDelete').onclick = function() {
        document.getElementById('delete-form-' + id).submit();
    };
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>
@endsection
