<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareerAssigned extends Model
{
    use HasFactory;

    protected $fillable = [
        'center_id',
        'career_id',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function center()
    {
        return $this->hasOne(Center::class, 'id', 'center_id');
    }

    public function career()
    {
        return $this->hasOne(Career::class, 'id', 'career_id');
    }

    public function teacher_courses_assigned()
    {
        return $this->hasMany(TeacherCourseAssigned::class, 'career_assigned_id', 'id');
    }
}
