<?php

// app/Models/Classroom.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    protected $fillable = ['name', 'building', 'capacity'];

    // Example relation if students are assigned to rooms
    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
