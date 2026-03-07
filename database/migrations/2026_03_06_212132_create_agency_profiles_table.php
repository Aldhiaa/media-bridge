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
        Schema::create('agency_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('agency_name');
            $table->string('contact_person');
            $table->string('email');
            $table->string('phone');
            $table->string('website')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->text('about')->nullable();
            $table->unsignedSmallInteger('years_experience')->nullable();
            $table->json('portfolio_links')->nullable();
            $table->decimal('minimum_budget', 12, 2)->nullable();
            $table->string('team_size')->nullable();
            $table->string('pricing_style')->nullable();
            $table->string('logo_path')->nullable();
            $table->boolean('is_complete')->default(false);
            $table->timestamps();

            $table->index(['city', 'country']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agency_profiles');
    }
};
