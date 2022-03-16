<?php

namespace Database\Seeders;

use App\Imports\MeccImport;
use App\Models\Grade;
use App\Models\User;
use App\Models\UserGrade;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

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

        $exampleMecc = 'https://raw.githubusercontent.com/NoteUniv/NoteUniv-Excel/main/dweb_mecc.xlsx';
        copy($exampleMecc, storage_path('app/public/mecc/dweb_mecc.xlsx'));
        Excel::import(new MeccImport, storage_path('app/public/mecc/dweb_mecc.xlsx'));

        // Grade::factory(10)->create();
        UserGrade::factory(10)->create();
    }
}
