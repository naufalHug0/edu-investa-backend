<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('risk_allocations', function (Blueprint $table) {
            $table->id();
            $table->decimal('allocation');
            $table->foreignId('risk_profiles_id');
            $table->foreignId('investment_asset_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('risk_allocations');
    }
};
