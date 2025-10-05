@extends('layouts.app')
@section('title', 'Tambah Dosen Baru')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-user-plus me-2"></i>Tambah Dosen Baru
                    </h4>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('dosen.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nip" class="form-label">
                                    <i class="fas fa-id-card me-1"></i>NIP
                                </label>
                                <input type="text" 
                                       class="form-control @error('nip') is-invalid @enderror" 
                                       id="nip" 
                                       name="nip" 
                                       value="{{ old('nip') }}"
                                       placeholder="Masukkan NIP">
                                @error('nip')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="nama" class="form-label">
                                    <i class="fas fa-user me-1"></i>Nama Lengkap <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('nama') is-invalid @enderror" 
                                       id="nama" 
                                       name="nama" 
                                       value="{{ old('nama') }}"
                                       placeholder="Masukkan nama lengkap"
                                       required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope me-1"></i>Email <span class="text-danger">*</span>
                                </label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}"
                                       placeholder="contoh@email.com"
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="no_telepon" class="form-label">
                                    <i class="fas fa-phone me-1"></i>No. Telepon
                                </label>
                                <input type="text" 
                                       class="form-control @error('no_telepon') is-invalid @enderror" 
                                       id="no_telepon" 
                                       name="no_telepon" 
                                       value="{{ old('no_telepon') }}"
                                       placeholder="08xxxxxxxxxx">
                                @error('no_telepon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="mata_kuliah" class="form-label">
                                <i class="fas fa-book me-1"></i>Mata Kuliah yang Diampu
                            </label>
                            <select class="form-select @error('mata_kuliah') is-invalid @enderror" 
                                    id="mata_kuliah" 
                                    name="mata_kuliah[]" 
                                    multiple>
                                <option value="">Pilih mata kuliah (opsional)</option>
                                @foreach(\App\Models\MataKuliah::all() as $mk)
                                    <option value="{{ $mk->id }}" {{ in_array($mk->id, old('mata_kuliah', [])) ? 'selected' : '' }}>
                                        {{ $mk->kode_mk }} - {{ $mk->nama_mk }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text">Anda dapat memilih lebih dari satu mata kuliah</div>
                            @error('mata_kuliah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-1"></i>Simpan
                            </button>
                            <a href="{{ route('dosen.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i>Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
