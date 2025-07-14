<?php

// app/Models/Course.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['title', 'code', 'credit'];

    public function studentCourses()
    {
        return $this->hasMany(StudentCourse::class);
    }
}
