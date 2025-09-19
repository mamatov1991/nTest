<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'name',
        'surname',
        'region_id',
        'district_id',
        'school_id',
        'class_number',
        'phone',
        'language',
        'password',
    ];

    // Agar subjects bilan bog'liq bo'lsa — many-to-many
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'student_subject');
    }
}
