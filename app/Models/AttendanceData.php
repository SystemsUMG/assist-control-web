<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceData extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_course_assigned_id',
        'total_assists',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function students_attendance()
    {
        return $this->hasMany(StudentAttendanceData::class, 'attendance_data_id', 'id');
    }

    public function teacher_course_assigned()
    {
        return $this->hasOne(TeacherCourseAssigned::class, 'id', 'teacher_course_assigned_id');
    }

}
