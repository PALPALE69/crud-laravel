<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Dosen>
 */
class DosenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nip' => $this->faker->unique()->numerify('19###########'),
            'nama' => $this->faker->name(),
            'email'=> $this->faker->unique()->safeEmail(),
            'no_telepon' => $this->faker->numerify('08##########'),
        ];
    }
}
