<?php

// app/Models/Semester.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    protected $fillable = ['name', 'year'];

    public function studentCourses()
    {
        return $this->hasMany(StudentCourse::class);
    }
}
