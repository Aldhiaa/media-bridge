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
        Schema::create('company_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('company_name');
            $table->string('brand_name')->nullable();
            $table->string('contact_person');
            $table->string('email');
            $table->string('phone');
            $table->string('website')->nullable();
            $table->foreignId('industry_id')->nullable()->constrained()->nullOnDelete();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->text('description')->nullable();
            $table->string('logo_path')->nullable();
            $table->boolean('is_complete')->default(false);
            $table->timestamps();

            $table->index(['industry_id', 'city', 'country']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_profiles');
    }
};
