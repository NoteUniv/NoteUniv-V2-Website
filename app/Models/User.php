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

    public function userGrades()
    {
        return $this->hasMany(UserGrade::class, 'student_id', 'student_id');
    }

    public function grades()
    {
        $grades = $this->userGrades->map(function ($grade) {
            $gradeValue =  $grade->grade_value;
            $grade = Grade::where('id', $grade->grade_id)->first();
            $meccId = $grade->mecc->id;
            $gradeCoefficient = $grade->mecc->coefficient;

            return [
                'grade_value' => $gradeValue,
                'mecc_id' => $meccId,
                'coefficient' => $gradeCoefficient,
            ];
        });

        return $grades;
    }

    public function averagePerSubject()
    {
        $gradePerSubject = [];
        foreach ($this->grades() as $grade) {
            $gradePerSubject[$grade['mecc_id']][] = $grade['grade_value'];
        }

        $averagePerSubject = [];
        foreach ($gradePerSubject as $mecc_id => $subjectGrades) {
            $subjectGrades = array_filter($subjectGrades);
            $subjectAverage = array_sum($subjectGrades) / count($subjectGrades);
            $averagePerSubject[$mecc_id] = $subjectAverage;
        }

        return $averagePerSubject;
    }

    public function overallAverage()
    {
        $coefPerSubject = [];

        foreach ($this->grades() as $grade) {
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
}
