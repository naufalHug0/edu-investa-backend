<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question_option extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public $timestamps = false;

    public function questions () {
        return $this->belongsTo(Question::class, 'question_id');
    }

    public function question_answers () {
        return $this->belongsTo(Question_option::class);
    }
}
