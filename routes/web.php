<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\DashboardController;

Route::get('/', fn() => redirect()->route('dosen.index'));
Route::resource('dosen', DosenController::class);
Route::resource('mahasiswa', MahasiswaController::class);
Route::resource('mata_kuliah', MataKuliahController::class);
Route::get('dashboard', [DashboardController::class, 'index']);