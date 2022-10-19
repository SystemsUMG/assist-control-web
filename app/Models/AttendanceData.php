<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceData extends Model
{
    use HasFactory;

    protected $fillable = ['*'];

    public function students_attendance()
    {
        $this->hasMany(StudentAttendanceData::class, 'attendance_data_id', 'id');
    }

    public function teacher_course_assigned()
    {
        $this->hasOne(TeacherCourseAssigned::class, 'id', 'teacher_course_assigned_id');
    }

}
