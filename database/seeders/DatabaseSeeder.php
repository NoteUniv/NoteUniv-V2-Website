<?php

namespace Database\Seeders;

use App\Models\Grade;
use App\Models\UserGrade;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        // Grade::factory(10)->create();
        UserGrade::factory(10)->create();
    }
}
