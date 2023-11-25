<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Departement;
use App\Models\Training;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        User::factory()->create();
        User::factory()->user()->create();
        Departement::factory(4)->create();
        Training::factory(4)->create();
    }
}
