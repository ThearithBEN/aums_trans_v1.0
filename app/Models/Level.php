<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $fillable = ['name_kh', 'name_en'];

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function majors()
    {
        return $this->belongsToMany(Major::class, 'level_major');
    }
}
