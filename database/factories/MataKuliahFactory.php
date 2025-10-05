<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MataKuliah>
 */
class MataKuliahFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $elektroNames = [
            'Sistem Elektronika', 'Pengukuran Listrik', 'Rangkaian Digital', 'Dasar Elektroteknik',
            'Elektronika Industri', 'Teknik Tenaga Listrik', 'Instrumentasi', 'Robotika',
            'Sistem Kontrol', 'Telekomunikasi', 'Mikrokontroler', 'Elektronika Medis'
        ];
        static $count = 0;
        $isElektro = $count < count($elektroNames);
        $data = [
            'kode_mk' => 'EL' . str_pad($count+1, 3, '0', STR_PAD_LEFT),
            'nama_mk' => $isElektro ? $elektroNames[$count] : ucfirst($this->faker->unique()->words(2, true)),
            'sks'  => $this->faker->numberBetween(2, 4),
        ];
        $count++;
        return $data;
    }
}
