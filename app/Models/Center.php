<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Center extends Model
{
    use HasFactory;

    protected $fillable = ['*'];

    public function careers_assignments()
    {
        $this->hasMany(CareerAssigned::class, 'center_id', 'id');
    }
}
