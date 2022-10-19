<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'year',
        'begin_date',
        'end_date'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function teacher_courses_assigned()
    {
        $this->hasMany(TeacherCourseAssigned::class, 'semester_id', 'id');
    }
}
