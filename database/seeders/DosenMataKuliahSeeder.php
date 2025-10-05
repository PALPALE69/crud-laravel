<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Dosen;
use App\Models\MataKuliah;

class DosenMataKuliahSeeder extends Seeder
{
    public function run(): void
    {
        // Buat 5 dosen
        $dosens = Dosen::insert([
            ['nama' => 'Dr. Ali Akbar', 'email' => 'ali.akbar@kampus.ac.id'],
            ['nama' => 'Budi Santoso', 'email' => 'budi.santoso@kampus.ac.id'],
            ['nama' => 'Citra Dewi', 'email' => 'citra.dewi@kampus.ac.id'],
            ['nama' => 'Dewi Lestari', 'email' => 'dewi.lestari@kampus.ac.id'],
            ['nama' => 'Eko Prasetyo', 'email' => 'eko.prasetyo@kampus.ac.id'],
        ]);
        $dosens = Dosen::all();
        // Buat 15 mata kuliah dan kaitkan ke dosen
        $matkuls = [
            ['nama' => 'Matematika Diskrit', 'sks' => 3],
            ['nama' => 'Pemrograman Web', 'sks' => 4],
            ['nama' => 'Basis Data', 'sks' => 3],
            ['nama' => 'Jaringan Komputer', 'sks' => 3],
            ['nama' => 'Sistem Operasi', 'sks' => 3],
            ['nama' => 'Algoritma & Struktur Data', 'sks' => 4],
            ['nama' => 'Kecerdasan Buatan', 'sks' => 3],
            ['nama' => 'Pemrograman Mobile', 'sks' => 3],
            ['nama' => 'Rekayasa Perangkat Lunak', 'sks' => 3],
            ['nama' => 'Manajemen Proyek TI', 'sks' => 2],
            ['nama' => 'Keamanan Informasi', 'sks' => 3],
            ['nama' => 'Cloud Computing', 'sks' => 3],
            ['nama' => 'Data Mining', 'sks' => 3],
            ['nama' => 'Sistem Informasi', 'sks' => 2],
            ['nama' => 'Machine Learning', 'sks' => 4],
        ];
        foreach ($matkuls as $i => $mk) {
            MataKuliah::create([
                'nama' => $mk['nama'],
                'sks' => $mk['sks'],
                'dosen_id' => $dosens[$i % $dosens->count()]->id,
            ]);
        }
    }
}
