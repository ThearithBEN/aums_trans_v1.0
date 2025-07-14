<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Level;

class Major extends Model
{
    use HasFactory;

    protected $fillable = ['name_kh', 'name_en', 'college_id', 'level_id'];

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function college()
    {
        return $this->belongsTo(College::class);
    }

    public function levels()
    {
        return $this->belongsToMany(Level::class, 'level_major', 'major_id', 'level_id');
    }
}
