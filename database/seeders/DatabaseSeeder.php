<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dosen;       // ✅ tambahkan ini
use App\Models\MataKuliah;  // ✅ dan ini juga

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        //buat 10 dosen
        $dosens = Dosen::factory(10)->create();

        //Buat 50 mata kuliah dan kaitkan ke dosen yang ada
        MataKuliah::factory(12)->make()->each(function ($mk) use ($dosens) {
            $mk->dosen_id = $dosens->random()->id;
            $mk->save();
        });
        MataKuliah::factory(38)->make()->each(function ($mk) use ($dosens) {
            $mk->dosen_id = $dosens->random()->id;
            $mk->save();
        });

    // Seed data mahasiswa
    $this->call(\Database\Seeders\MahasiswaSeeder::class);
    // Seed data dosen dan mata kuliah
    $this->call(\Database\Seeders\DosenMataKuliahSeeder::class);
    }
}
