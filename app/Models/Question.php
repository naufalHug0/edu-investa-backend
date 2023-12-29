<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public $timestamps = false;

    public function quizzes () {
        return $this->belongTo(Quiz::class, 'quiz_id');
    }

    public function question_options()
    {
        return $this->hasMany(Question_option::class);
    }

    public function question_levels ()
    {
        return $this->belongsTo(Question_level::class, 'level_id');
    }
}
