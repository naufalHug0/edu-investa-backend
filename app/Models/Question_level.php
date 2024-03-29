<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question_level extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public $timestamps = false;

    public function questions () {
        return $this->hasMany(Question::class);
    }
}
