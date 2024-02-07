<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function videos () {
        return $this->hasMany(Video::class);
    }

    public function course_levels () {
        return $this->belongsTo(Course_level::class, 'course_level_id');
    }
}
