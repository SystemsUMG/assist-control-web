<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = ['letter'];

    protected $hidden = ['created_at', 'updated_at'];

    public function teacher_courses_assigned()
    {
        $this->hasMany(TeacherCourseAssigned::class, 'section_id', 'id');
    }
}
