<?php

namespace App\Models;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminInfo extends Model
{
    use HasFactory;

    protected $table = 'admin_info';

    protected $fillable = [
        'real_name_kh',
        'real_name_en',
        'gender_id',
        'social_media_id',
        'phone_number',
        'profile_urls',
        'created_by_id',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id', 'info_id');
    }
}
