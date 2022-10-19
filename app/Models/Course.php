<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'career_id',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function career()
    {
        $this->hasOne(Career::class, 'id', 'career_id');
    }

    public function teacher_courses_assigned()
    {
        $this->hasMany(TeacherCourseAssigned::class, 'course_id', 'id');
    }
}
