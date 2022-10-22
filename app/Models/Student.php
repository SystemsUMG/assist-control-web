<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'last_name',
        'email',
        'password',
        'begin_date',
        'end_date',
        'age',
        'dpi',
        'carnet',
        'career_assigned_id',
    ];

    protected $hidden = ['created_at', 'updated_at', 'password'];

    public function career_assigned()
    {
        return $this->hasOne(CareerAssigned::class, 'id', 'career_assigned_id');
    }

    public function student_courses_assigned()
    {
        return $this->hasMany(StudentCourseAssigned::class, 'student_id', 'id');
    }
}
