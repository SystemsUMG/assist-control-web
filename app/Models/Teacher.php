<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Teacher extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

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
        $this->hasMany(TeacherCourseAssigned::class, 'teacher_id', 'id');
    }
}
