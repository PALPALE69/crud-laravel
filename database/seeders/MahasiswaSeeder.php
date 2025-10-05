<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Mahasiswa;

class MahasiswaSeeder extends Seeder
{
    public function run(): void
    {
        Mahasiswa::insert([
            [
                'nama' => 'Ali Akbar',
                'nim' => '2101001',
                'email' => 'ali.akbar@example.com',
            ],
            [
                'nama' => 'Budi Santoso',
                'nim' => '2101002',
                'email' => 'budi.santoso@example.com',
            ],
            [
                'nama' => 'Citra Dewi',
                'nim' => '2101003',
                'email' => 'citra.dewi@example.com',
            ],
            [
                'nama' => 'Dewi Lestari',
                'nim' => '2101004',
                'email' => 'dewi.lestari@example.com',
            ],
            [
                'nama' => 'Eko Prasetyo',
                'nim' => '2101005',
                'email' => 'eko.prasetyo@example.com',
            ],
        ]);
    }
}
