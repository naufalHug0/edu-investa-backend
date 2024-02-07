<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset_change extends Model
{
    use HasFactory;

    public function investment_assets() {
        return $this->belongsTo(Investment_asset::class, 'investment_assets_id');
    }
}
