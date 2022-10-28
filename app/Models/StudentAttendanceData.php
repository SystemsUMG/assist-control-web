<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAttendanceData extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_course_assigned_id',
        'schedule_register',
        'observations',
    ];

    protected $hidden = ['updated_at'];

    protected $dateFormat = 'Y-m-d';

    public function student_course_assigned()
    {
        return $this->hasOne(StudentCourseAssigned::class, 'id', 'student_course_assigned_id');
    }
}
