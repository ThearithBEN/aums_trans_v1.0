<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class UserInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'real_name_kh',
        'real_name_en',
        'social_media_id',
        'phone_number',
        'profile_urls',
        'created_by_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'info_id');
    }
}
