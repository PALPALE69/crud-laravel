@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Edit Mata Kuliah</h1>
    <form action="{{ route('mata_kuliah.update', $mata_kuliah->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Mata Kuliah</label>
            <input type="text" class="form-control" id="nama" name="nama" value="{{ $mata_kuliah->nama }}" required>
        </div>
        <div class="mb-3">
            <label for="kode" class="form-label">Kode</label>
            <input type="text" class="form-control" id="kode" name="kode" value="{{ $mata_kuliah->kode }}" required>
        </div>
        <div class="mb-3">
            <label for="sks" class="form-label">SKS</label>
            <input type="number" class="form-control" id="sks" name="sks" value="{{ $mata_kuliah->sks }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('mata_kuliah.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
