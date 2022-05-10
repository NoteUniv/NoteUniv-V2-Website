<?php

namespace Database\Seeders;

use App\Imports\MeccImport;
use App\Models\Grade;
use App\Models\Mecc;
use App\Models\User;
use App\Models\UserGrade;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
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
        Schema::disableForeignKeyConstraints();
        UserGrade::truncate();
        User::truncate();
        Grade::truncate();
        Mecc::truncate();

        User::create([
            'email' => 'admin@unistra.fr',
            'is_admin' => true,
            'is_ranked' => false,
            'password' => Hash::make('admin'),
        ]);
        User::factory(10)->unverified()->create();

        $exampleMecc = 'https://raw.githubusercontent.com/NoteUniv/NoteUniv-Excel/main/dweb_mecc.xlsx';
        copy($exampleMecc, storage_path('app/public/dweb_mecc.xlsx'));
        Excel::import(new MeccImport, storage_path('app/public/dweb_mecc.xlsx'));

        Grade::factory(10)->create();

        Grade::All()->each(function (Grade $grade) {
            User::All()->each(function ($user) use ($grade) {
                if ($user->student_id !== null) {
                    UserGrade::factory()->create([
                        'student_id' => $user->student_id,
                        'grade_id' => $grade->id,
                    ]);
                }
            });
        });

        echo 'Created a few users, grades and grades for students.' . PHP_EOL;
        echo 'You can now login with:' . PHP_EOL;
        $user = User::where('student_id', '!=', null)->inRandomOrder()->first();
        echo 'email: ' . $user->email . PHP_EOL;
        echo 'password: ' . $user->student_id . PHP_EOL;
    }
}
