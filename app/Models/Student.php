<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'name',
        'father_name',
        'mother_name',
        'dob_pass',
        'dob',
        'gender',
        'phone',
        'email',
        'app_number',
        'physically_challanged_category',
        'folder_number',
        'roll_number',
        'center_detail'
    ];
}
