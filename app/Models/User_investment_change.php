<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_investment_change extends Model
{
    use HasFactory;

    public function user_investments () {
        return $this->belongsTo(User_investment::class, 'user_investment_id');
    }
}
