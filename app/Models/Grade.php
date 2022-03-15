<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'mecc_id',
        'name',
        'teacher',
        'grade_type',
        'exam_type',
        'exam_date',
    ];

    public function mecc()
    {
        return $this->belongsTo(Mecc::class);
    }

    public function userGrades()
    {
        return $this->belongsTo(UserGrade::class);
    }
}
