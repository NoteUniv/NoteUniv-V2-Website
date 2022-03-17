<?php

namespace App\Imports;

use App\Models\Grade;
use App\Models\Mecc;
use App\Models\User;
use App\Models\UserGrade;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use PhpOffice\PhpSpreadsheet\Shared\Date;

HeadingRowFormatter::default('none');

class GradesImport implements ToCollection, WithMultipleSheets
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        $teacher = $rows[3][1];
        $gradeType = $rows[5][1];
        $examType = $rows[7][1];
        $semester = $rows[9][1];
        $promo = $rows[3][3];
        $subject = $rows[5][3];
        $name = $rows[7][3];
        $examDate = Date::excelToDateTimeObject(intval($rows[9][3]));

        $mecc = Mecc::where('subject_name', $subject)->where('promo', $promo)->first();

        // Create a grade if it doesn't exist
        $grade = Grade::firstOrCreate([
            'mecc_id' => $mecc->id,
            'name' => $name,
            'teacher' => $teacher,
            'grade_type' => $gradeType,
            'exam_type' => $examType,
            'exam_date' => $examDate->format('Y-m-d'),
        ]);

        $gradeId = $grade->id;

        // skip first 12 rows
        $rows = $rows->slice(12);

        foreach ($rows as $row) {
            if (empty($row[0])) {
                continue;
            }

            $studentId = $row[1];
            $grade = $row[3];

            // grade data does not exist, create it else update student grade
            $gradeExists = UserGrade::where('student_id', $studentId)->where('grade_id', $gradeId);
            if (!$gradeExists->exists()) {
                UserGrade::create([
                    'student_id' => $studentId,
                    'grade_id' => $gradeId,
                    'grade_value' => $grade,
                ]);
            } else {
                $gradeExists->update([
                    'grade_value' => $grade,
                ]);
            }
        }

        $allUsers = User::all();
        $users = UserGrade::where('grade_id', $gradeId)->pluck('student_id');
        foreach ($allUsers as $user) {
            if ($users->contains($user->student_id)) {
                mail($user->email, 'Nouvelle note', 'Vous avez reçu une nouvelle note!');
            }
        }
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        // Load only first sheet
        return [
            0 => $this,
        ];
    }
}
