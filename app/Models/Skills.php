<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skills extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public $timestamps = false;

    public function user_skills_inventories () {
        return $this->hasMany(User_skills_inventory::class);
    }
}
