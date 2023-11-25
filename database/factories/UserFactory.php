<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{

    public function definition()
    {
        return [
            'id_departement' => 1,
            'name' => 'Bejo',
            'role' => 'admin',
            'nik' => '1234567890',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('admin123123'), // Ganti dengan kata sandi yang Anda inginkan
            'remember_token' => Str::random(10),
        ];
    }

    // Tambahkan definisi lain untuk role "user"
    public function user()
    {
        return $this->state([
            'name' => 'Nama User',
            'role' => 'user',
            'email' => 'user@gmail.com',
            'password' => bcrypt('user123123'),
        ]);
    }


    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
