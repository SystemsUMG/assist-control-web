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
