<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'last_name',
        'active',
        'email',
        'password',
        'address',
        'phone',
    ];

    protected $hidden = ['created_at', 'updated_at', 'password'];

    public function teacher_courses_assigned()
    {
        return $this->hasMany(TeacherCourseAssigned::class, 'teacher_id', 'id');
    }
}
