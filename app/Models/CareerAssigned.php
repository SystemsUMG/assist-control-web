<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareerAssigned extends Model
{
    use HasFactory;

    protected $fillable = ['*'];

    public function centers()
    {
        $this->hasOne(Center::class, 'id', 'center_id');
    }

    public function careers()
    {
        $this->hasOne(Career::class, 'id', 'career_id');
    }

    public function teacher_courses_assigned()
    {
        $this->hasMany(TeacherCourseAssigned::class, 'career_assigned_id', 'id');
    }
}
