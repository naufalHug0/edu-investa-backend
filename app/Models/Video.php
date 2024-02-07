<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public $timestamps = true;

    public function courses () {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
