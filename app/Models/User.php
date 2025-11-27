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
        'is_ranked',
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

        if (!$lastGrade) {
            return [
                'current_semester' => 1,
                'max_semester' => 2,
                'promo' => '',
                'year' => date('Y'),
            ];
        }

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

    public function grades()
    {
        $allGrades = Grade::all();
        $allMecc = Mecc::all();

        $grades = $this->userGrades->map(function ($userGrade) use ($allGrades, $allMecc) {
            $grade = $allGrades->where('id', $userGrade->grade_id)->first();
            $grade->grade_value = $userGrade->grade_value;
            $mecc = $allMecc->where('id', $grade->mecc_id)->first();

            return [
                'userGrade' => $userGrade,
                'grade' => $grade,
                'mecc' => $mecc,
                'mecc_id' => $grade->mecc_id,
                'value' => $grade->grade_value,
                'coefficient' =>  $mecc->coefficient,
            ];
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

        if (count($this->grades) === 0) {
            return 20;
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
        $usersGrades = UserGrade::all();

        foreach ($this->grades() as $data) {
            $lastGrades[$data['grade']->id] = [
                'date' => $data['grade']->exam_date,
                'subject_name' => $data['mecc']->subject_code ?? $data['mecc']->subject_name,
                'grade_id' => $data['grade']->id,
                'grade_name' => $data['grade']->name,
                'grade_value' => $data['userGrade']->grade_value,
                'class_avg' => $usersGrades->where('grade_id', $data['grade']->id)->avg('grade_value')
            ];
        }

        usort($lastGrades, function ($a, $b) {
            return $b['date'] <=> $a['date'];
        });

        return $lastGrades ?? [];
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

        if ($allStudents->count() === 0) {
            return [];
        }

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
            return $b['student_avg'] <=> $a['student_avg'];
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

        $rank = 0;
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
        foreach ($this->grades() as $data) {
            $groupedGrades[$data['mecc']->ue][$data['mecc']->id][] = [
                'gradeValue' => $data['userGrade']->grade_value,
                'gradeMin' => $usersGrades->where('grade_id', $data['grade']->id)->min('grade_value'),
                'gradeMax' => $usersGrades->where('grade_id', $data['grade']->id)->max('grade_value'),
                'gradeAvg' => $usersGrades->where('grade_id', $data['grade']->id)->avg('grade_value'),
                'subjectName' => $data['mecc']->subject_name,
                'subjectCoef' => $data['mecc']->coefficient,
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

        foreach ($groupedGrades as $ue => $ueData) {
            foreach ($ueData as $meccId => $studentData) {
                $subjectName = $groupedGrades[$ue][$meccId][0]['subjectName'];
                $subjectCoef = $groupedGrades[$ue][$meccId][0]['subjectCoef'];

                $subjectAvg = 0;
                $classAvg = 0;
                $classMin = 0;
                $classMax = 0;
                foreach ($studentData as $grade) {
                    $subjectAvg += $grade['gradeValue'];
                    $classAvg += $grade['gradeAvg'];
                    $classMin += $grade['gradeMin'];
                    $classMax += $grade['gradeMax'];
                }

                $subjectAvg /= count($studentData);
                $classAvg /= count($studentData);
                $classMin /= count($studentData);
                $classMax /= count($studentData);

                $groupedGrades[$ue][$meccId][] = [
                    'subjectName' => $subjectName,
                    'subjectCoef' => $subjectCoef,
                    'subjectAvg' => $subjectAvg,
                    'classAvg' => $classAvg,
                    'classMin' => $classMin,
                    'classMax' => $classMax,
                    'studentData' => $studentData,
                ];

                $groupedGrades[$ue][$meccId] = array_slice($groupedGrades[$ue][$meccId], count($groupedGrades[$ue][$meccId]) - 1);
            }

            $ueAvg = 0;
            foreach ($groupedGrades[$ue] as $meccId => $meccData) {
                $ueAvg += $meccData[0]['subjectAvg'];
            }
            $ueAvg /= count($groupedGrades[$ue]);

            $groupedGrades[$ue] = [
                'ueId' => $ue,
                'ueData' => $groupedGrades[$ue],
                'ueAvg' => $ueAvg,
            ];
        }

        return $groupedGrades;
    }
}
