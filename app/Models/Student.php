<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['*'];

    public function careers_assigned()
    {
        $this->hasOne(CareerAssigned::class, 'id', 'career_assigned_id');
    }

    public function student_courses_assigned()
    {
        $this->hasMany(StudentCourseAssigned::class, 'student_id', 'id');
    }
}
