<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Risk_profile extends Model
{
    use HasFactory;

    public function risk_allocations() {
        return $this->hasMany(Risk_allocation::class, 'risk_profiles_id');
    }
}
