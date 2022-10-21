<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentCourseAssigned extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'teacher_course_assigned_id',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function student()
    {
        $this->hasOne(Student::class, 'id', 'student_id');
    }

    public function teacher_courses_assigned()
    {
        $this->hasOne(TeacherCourseAssigned::class, 'id', 'teacher_course_assigned_id');
    }

    public function attendances()
    {
        $this->hasMany(StudentAttendanceData::class, 'student_course_assigned_id', 'id');
    }
}
