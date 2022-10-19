<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherCourseAssigned extends Model
{
    use HasFactory;

    protected $fillable = ['*'];

    public function students_assigned()
    {
        $this->hasMany(StudentCourseAssigned::class, 'teacher_course_assigned_id', 'id');
    }

    public function attendance_data()
    {
        $this->hasOne(AttendanceData::class, 'teacher_course_assigned_id', 'id');
    }

    public function career_assigned()
    {
        $this->hasOne(CareerAssigned::class, 'id', 'career_assigned_id');
    }

    public function teacher()
    {
        $this->hasOne(Teacher::class, 'id', 'teacher_id');
    }

    public function section()
    {
        $this->hasOne(Section::class, 'id', 'section_id');
    }

    public function schedule()
    {
        $this->hasOne(Schedule::class, 'id', 'schedule_id');
    }

    public function course()
    {
        $this->hasOne(Course::class, 'id', 'course_id');
    }

    public function semester()
    {
        $this->hasOne(Semester::class, 'id', 'semester_id');
    }
}
