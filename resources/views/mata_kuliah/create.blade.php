@extends('layouts.app')
@section('title', 'Tambah Mata Kuliah Baru')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-book-open me-2"></i>Tambah Mata Kuliah Baru
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

                    <form action="{{ route('mata_kuliah.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="kode_mk" class="form-label">
                                    <i class="fas fa-code me-1"></i>Kode Mata Kuliah <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('kode_mk') is-invalid @enderror" 
                                       id="kode_mk" 
                                       name="kode_mk" 
                                       value="{{ old('kode_mk') }}"
                                       placeholder="Contoh: IF101"
                                       required>
                                @error('kode_mk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="sks" class="form-label">
                                    <i class="fas fa-calculator me-1"></i>SKS <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('sks') is-invalid @enderror" 
                                        id="sks" 
                                        name="sks" 
                                        required>
                                    <option value="">Pilih SKS</option>
                                    @for($i = 1; $i <= 6; $i++)
                                        <option value="{{ $i }}" {{ old('sks') == $i ? 'selected' : '' }}>
                                            {{ $i }} SKS
                                        </option>
                                    @endfor
                                </select>
                                @error('sks')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="nama_mk" class="form-label">
                                <i class="fas fa-book me-1"></i>Nama Mata Kuliah <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('nama_mk') is-invalid @enderror" 
                                   id="nama_mk" 
                                   name="nama_mk" 
                                   value="{{ old('nama_mk') }}"
                                   placeholder="Masukkan nama mata kuliah"
                                   required>
                            @error('nama_mk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="dosen_id" class="form-label">
                                <i class="fas fa-chalkboard-teacher me-1"></i>Dosen Pengampu
                            </label>
                            <select class="form-select @error('dosen_id') is-invalid @enderror" 
                                    id="dosen_id" 
                                    name="dosen_id">
                                <option value="">Pilih Dosen (Opsional)</option>
                                @foreach($dosens as $dosen)
                                    <option value="{{ $dosen->id }}" {{ old('dosen_id') == $dosen->id ? 'selected' : '' }}>
                                        {{ $dosen->nama }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text">Dosen dapat diisi nanti atau melalui form edit dosen</div>
                            @error('dosen_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-1"></i>Simpan
                            </button>
                            <a href="{{ route('mata_kuliah.index') }}" class="btn btn-secondary">
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
