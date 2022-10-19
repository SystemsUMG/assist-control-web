<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = ['*'];

    public function teacher_courses_assigned()
    {
        $this->hasMany(TeacherCourseAssigned::class, 'teacher_id', 'id');
    }
}
