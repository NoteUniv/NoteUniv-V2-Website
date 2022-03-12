<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mecc extends Model
{
    use HasFactory;

    protected $table = 'mecc';

    public $timestamps = false;

    protected $fillable = [
        'ue',
        'semester',
        'subject_code',
        'subject_name',
        'coefficient',
        'promo',
        'year',
        'hidden_id',
    ];
}
