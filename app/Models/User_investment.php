<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_investment extends Model
{
    use HasFactory;

    public function user_investment_changes () {
        return $this->hasMany(User_investment_change::class);
    }
}
