<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DepartementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    { {
            $departements = ['humaresource', 'sales', 'purchasiong', 'vendor', 'production'];

            return [
                'nama' => $departements[$this->faker->unique()->numberBetween(0, 4)],
            ];
        }
    }
}
