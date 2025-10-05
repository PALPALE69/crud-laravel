<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    /** @use HasFactory<\Database\Factories\MataKuliahFactory> */
    use HasFactory;
    protected $fillable = ['kode_mk', 'nama_mk', 'sks', 'dosen_id'];
    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }
}
