<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resume extends Model
{
    use HasFactory;
    protected $fillable = [
        'username',
        'country',
        'city',
        'proficiency',
        'work_samples',
        'educational_records',
        'achievement',
        'profile_photo_path',
        'other_information',
        'work_resume',
        'title',
        'role',
        'Holidays',
        'user_id'
    ];
    public function user()
    {

        return $this->belongsTo(User::class, 'user_id');
    }
}
