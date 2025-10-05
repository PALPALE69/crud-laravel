<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    /** @use HasFactory<\Database\Factories\DosenFactory> */
    use HasFactory;
    protected $fillable = ['nip', 'nama', 'email', 'no_telepon'];
    public function mataKuliah()
    {
        return $this->hasMany(MataKuliah::class);
    }
}
