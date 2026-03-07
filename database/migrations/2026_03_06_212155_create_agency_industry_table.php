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
        Schema::create('agency_industry', function (Blueprint $table) {
            $table->foreignId('agency_profile_id')->constrained()->cascadeOnDelete();
            $table->foreignId('industry_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->primary(['agency_profile_id', 'industry_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agency_industry');
    }
};
