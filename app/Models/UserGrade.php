<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserGrade extends Model
{
    use HasFactory;

    protected $table = 'users_grades';

    public $timestamps = false;

    protected $fillable = [
        'student_id',
        'grade_id',
        'grade_value',
    ];

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
