<?php

namespace Database\Seeders;

use App\Models\Grade;
use App\Models\User;
use App\Models\UserGrade;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'email' => 'admin@noteuniv.fr',
            'is_admin' => true,
            'is_ranked' => false,
            'password' => Hash::make('admin'),
        ]);
        // Grade::factory(10)->create();
        UserGrade::factory(10)->create();
    }
}
