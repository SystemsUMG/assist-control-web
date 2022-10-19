<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    use HasFactory;

    protected $fillable = ['*'];

    public function courses()
    {
        $this->hasMany(Course::class, 'career_id', 'id');
    }

    public function centers_assigned()
    {
        $this->hasMany(CareerAssigned::class, 'career_id', 'id');
    }
}
