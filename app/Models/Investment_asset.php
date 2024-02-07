<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investment_asset extends Model
{
    use HasFactory;

    public function asset_changes() {
        return $this->hasMany(Asset_change::class);
    }

    public function risk_allocations() {
        return $this->hasMany(Investment_asset::class);
    }
}
