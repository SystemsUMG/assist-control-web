<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'description',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function courses()
    {
        return $this->hasMany(Course::class, 'career_id', 'id');
    }

    public function centers_assigned()
    {
        return $this->hasMany(CareerAssigned::class, 'career_id', 'id');
    }
}
