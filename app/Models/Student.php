<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'register_date',
        'name_kh',
        'name_en',
        'gender_id',
        'dob',
        'study_shift_id',
        'course_id',
        'cadre_id',
        'level_id',
        'major_id',
        'faculty_id',
        'college_id',
        'province_id',
        'high_school',
        'p_phone',
        'par_phone',
        'study_year',
        'scholarship',
        'yde',
        'diploma_number',
        'diploma_grade',
        'dkg',
        'dmg',
        'dpg',
        'dchg',
        'dbg',
        'dhg',
        'dgg',
        'dcg',
        'desg',
        'dflg',
        'plan_id',
        'reference_id',
        'refer_by_name',
        'refer_by_phone',
        'user_id',
        'admin_id',
        'generation_id',
        'semester_id',
        'plans',
    ];

    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id');
    }

    public function major()
    {
        return $this->belongsTo(Major::class, 'major_id');
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculty_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function reference()
    {
        return $this->belongsTo(Reference::class, 'reference_id');
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }

    public function cadre()
    {
        return $this->belongsTo(Cadre::class, 'cadre_id');
    }

    public function highSchool()
    {
        return $this->belongsTo(HighSchool::class, 'high_school', 'name_kh');
    }

    public function generation()
    {
        return $this->belongsTo(Generation::class, 'generation_id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }
    
    public function studentCourses()
    {
        return $this->hasMany(StudentCourse::class);
    }
}
