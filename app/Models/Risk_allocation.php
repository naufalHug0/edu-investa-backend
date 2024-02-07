<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Risk_allocation extends Model
{
    use HasFactory;

    public function risk_profiles () {
        return $this->belongsTo(Risk_profile::class, 'risk_profiles_id');
    }
    public function investment_assets() {
        return $this->belongsTo(Investment_asset::class, 'investment_asset_id');
    }
}
