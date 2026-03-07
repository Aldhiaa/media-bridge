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
        Schema::create('campaign_favorites', function (Blueprint $table) {
            $table->foreignId('campaign_id')->constrained()->cascadeOnDelete();
            $table->foreignId('agency_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();

            $table->primary(['campaign_id', 'agency_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaign_favorites');
    }
};
