<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = ['*'];

    public function teacher_courses_assigned()
    {
        $this->hasMany(TeacherCourseAssigned::class, 'section_id', 'id');
    }
}
