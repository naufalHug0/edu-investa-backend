<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_skills_inventory extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public $timestamps = false;

    public function skills () {
        return $this->belongsTo(Skills::class, 'skills_id');
    }
}
