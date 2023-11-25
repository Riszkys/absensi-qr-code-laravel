<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TrainingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $nama_training = ['Renang', 'Lari', 'Estavet', 'Karate', 'Balap'];

        return [
            'nama_training' => $nama_training[$this->faker->numberBetween(0, 4)],
            'waktu_mulai' => $this->faker->time,
            'lokasi_training' => $this->faker->address,
            'pic' => $this->faker->name,
            'tanggal_training' => $this->faker->date,
            'status_training' => $this->faker->word,
            'materi_training' => $this->faker->sentence,
        ];
    }
}
