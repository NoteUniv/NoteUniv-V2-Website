<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'student_id',
        'email',
        'password',
        'email_notifications',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Indicates if the user is a student
     *
     * @var bool
     */
    public function getIsStudentAttribute()
    {
        return $this->student_id !== null;
    }

    /**
     * Get last data from a user using its grades
     *
     * @return int
     */
    public function getDataAttribute()
    {
        $lastGrade = $this->userGrades->sortByDesc('grade_id')->first();
        $lastGradeMecc = $lastGrade->grade->mecc;

        $maxSemester = Mecc::where('year', $lastGradeMecc->year)->max('semester');

        return [
            'current_semester' => $lastGradeMecc->semester,
            'max_semester' => $maxSemester,
            'promo' => $lastGradeMecc->promo,
            'year' => $lastGradeMecc->year,
        ];
    }

    public function userGrades()
    {
        return $this->hasMany(UserGrade::class, 'student_id', 'student_id');
    }

    public $grades;

    public function grades($full = false)
    {
        $allGrades = Grade::all();
        $allMecc = Mecc::all();

        $grades = $this->userGrades->map(function ($userGrade) use ($full, $allGrades, $allMecc) {
            $grade = $allGrades->where('id', $userGrade->grade_id)->first();
            $mecc = $allMecc->where('id', $grade->mecc_id)->first();

            if ($full) {
                return [
                    'userGrade' => $userGrade,
                    'grade' => $grade,
                    'mecc' => $mecc,
                ];
            } else {
                return [
                    'mecc_id' => $grade->mecc_id,
                    'value' => $grade->grade_value,
                    'coefficient' =>  $mecc->coefficient,
                ];
            }
        });

        $this->grades = $grades;

        return $grades;
    }

    public function averagePerSubject()
    {
        if ($this->grades === null) {
            $this->grades = $this->grades();
        }

        $gradePerSubject = [];
        foreach ($this->grades as $grade) {
            $gradePerSubject[$grade['mecc_id']][] = $grade['value'];
        }

        $averagePerSubject = [];
        foreach ($gradePerSubject as $mecc_id => $subjectGrades) {
            $subjectGrades = array_filter($subjectGrades);
            if ($subjectGrades) {
                $subjectAverage = array_sum($subjectGrades) / count($subjectGrades);
            } else {
                $subjectAverage = 0;
            }
            $averagePerSubject[$mecc_id] = $subjectAverage;
        }

        return $averagePerSubject;
    }

    public function overallAverage()
    {
        if ($this->grades === null) {
            $this->grades = $this->grades();
        }

        $coefPerSubject = [];
        foreach ($this->grades as $grade) {
            if (!array_key_exists($grade['mecc_id'], $coefPerSubject)) {
                $coefPerSubject[$grade['mecc_id']] = $grade['coefficient'];
            }
        }

        $overallAverage = 0;
        foreach ($this->averagePerSubject() as $mecc_id => $subjectAverage) {
            $overallAverage += $subjectAverage * $coefPerSubject[$mecc_id];
        }

        $allCoefficients = 0;
        foreach ($coefPerSubject as $subjectCoef) {
            $allCoefficients += $subjectCoef;
        }

        $overallAverage = $overallAverage / $allCoefficients;

        return $overallAverage;
    }

    public function lastGrades()
    {
        $usersGrades = UserGrade::all()->sortByDesc('exam_date');

        foreach ($this->grades(true) as $data) {
            $lastGrades[$data['grade']->id] = [
                'date' => $data['grade']->exam_date,
                'subject_name' => $data['mecc']->subject_code ?? $data['mecc']->subject_name,
                'grade_name' => $data['grade']->name,
                'grade_value' => $data['userGrade']->grade_value,
                'class_avg' => $usersGrades->where('grade_id', $data['grade']->id)->avg('grade_value')
            ];
        }

        return $lastGrades;
    }

    public function averageAllStudents()
    {
        $allUsers = User::all();

        $allStudents = UserGrade::select('student_id')
            ->join('grades', 'grades.id', '=', 'users_grades.grade_id')
            ->join('mecc', 'mecc.id', '=', 'grades.mecc_id')
            ->where('mecc.semester', 1)
            ->where('mecc.promo', $this->data['promo'])
            ->groupBy('student_id')
            ->get();

        foreach ($allStudents as $student) {
            // $existingStudent = $allUsers->where('student_id', $student->student_id)->first();
            // if ($existingStudent) {
            //     if ($existingStudent->is_ranked) {
            //         $allAverages[] = [
            //             'student_id' => $existingStudent->student_id,
            //             'student_avg' => $existingStudent->overallAverage(),
            //         ];
            //     } else {
            //         $allAverages[] = [
            //             'student_id' => null,
            //             'student_avg' => null,
            //         ];
            //     }
            // } else {
            //     $newStudent = new User([
            //         'student_id' => $student->student_id,
            //     ]);
            //     $allAverages[] = [
            //         'student_id' => $newStudent->student_id,
            //         'student_avg' => $newStudent->overallAverage(),
            //     ];
            // }
            $newStudent = new User([
                'student_id' => $student->student_id,
            ]);
            $allAverages[] = [
                'student_id' => $newStudent->student_id,
                'student_avg' => $newStudent->overallAverage(),
            ];
        }

        usort($allAverages, function ($a, $b) {
            return $a['student_avg'] < $b['student_avg'];
        });

        foreach ($allAverages as $key => $data) {
            $existingStudent = $allUsers->where('student_id', $data['student_id'])->first();
            if ($existingStudent && $existingStudent->is_ranked) {
                $allAverages[$key]['rank'] = $key + 1;
            } else {
                $allAverages[$key]['rank'] = null;
            }
        }

        return $allAverages ?? [];
    }

    public function getRankAttribute()
    {
        $allAverages = $this->averageAllStudents();

        $rank = null;
        foreach ($allAverages as $key => $data) {
            if ($data['student_id'] === $this->student_id) {
                $rank = $key + 1;
            }
        }

        return [$rank, count($allAverages)];
    }

    public function groupGrades()
    {
        $usersGrades = UserGrade::all();

        $groupedGrades = [];
        foreach ($this->grades(true) as $data) {
            $groupedGrades[$data['mecc']->ue][$data['mecc']->id][] = [
                'value' => $data['userGrade']->grade_value,
                'gradeMin' => $usersGrades->where('grade_id', $data['grade']->id)->min('grade_value'),
                'gradeMax' => $usersGrades->where('grade_id', $data['grade']->id)->max('grade_value'),
                'gradeAvg' => $usersGrades->where('grade_id', $data['grade']->id)->avg('grade_value'),
                'subjectName' => $data['mecc']->subject_name,
                'name' => $data['grade']->name,
                'teacher' => $data['grade']->teacher,
                'type' => $data['grade']->grade_type,
                'exam' => $data['grade']->exam_type,
                'date' => $data['grade']->exam_date,
            ];

            // $groupedGrades[$data['mecc']->ue][$data['mecc']->id][$data['grade']->id] = [
            //     'subject_name' => $data['mecc']->subject_name,
            //     'subject_data' => [],
            // ];

            // $groupedGrades[$data['mecc']->ue][$data['mecc']->id][$data['grade']->id]['subject_data'] = [
            //     'value' => $data['userGrade']->grade_value,
            //     'gradeMin' => $usersGrades->where('grade_id', $data['grade']->id)->min('grade_value'),
            //     'gradeMax' => $usersGrades->where('grade_id', $data['grade']->id)->max('grade_value'),
            //     'gradeAvg' => $usersGrades->where('grade_id', $data['grade']->id)->avg('grade_value'),
            //     'name' => $data['grade']->name,
            //     'teacher' => $data['grade']->teacher,
            //     'type' => $data['grade']->grade_type,
            //     'exam' => $data['grade']->exam_type,
            //     'date' => $data['grade']->exam_date,
            // ];
        }

        return $groupedGrades;
    }
}
