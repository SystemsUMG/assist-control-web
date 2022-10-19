<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAttendanceData extends Model
{
    use HasFactory;

    protected $fillable = [
        'attendance_data_id',
        'student_course_assigned_id',
        'schedule_register',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function student_course_assigned()
    {
        $this->hasOne(StudentCourseAssigned::class, 'id', 'student_course_assigned_id');
    }

    public function attendance_data()
    {
        $this->hasOne(AttendanceData::class, 'attendance_data_id', 'id');
    }
}
