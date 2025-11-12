<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamCoordinator extends Model
{
    use HasFactory;
    protected $table = 'exam_coordinators';
    protected $fillable = ['center_id', 'name', 'email', 'phone', 'state', 'city', 'address', 'zip', 'password', 'status'];

    public function center()
    {
        return $this->belongsTo(Center::class, 'center_id');
    }
}
