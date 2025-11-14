<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Center extends Model
{
    use HasFactory;

    protected $table = 'centers';
    protected $fillable = ['name','district', 'address', 'contact_person', 'contact_number'];
}
