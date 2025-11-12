<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
       'application_id',
        'candidate_first_name',
        'candidate_last_name',
        'candidate_mobile_number',
        'dob',
        'email',
        'gender',
        'category',
        'skill_name',
        'team_individual', 
        'current_state',
        'current_district',
        'center_detail',
        'is_download',
    ];

    public function center()
    {
        return $this->belongsTo(Center::class, 'center_detail', 'id');
    }
}
