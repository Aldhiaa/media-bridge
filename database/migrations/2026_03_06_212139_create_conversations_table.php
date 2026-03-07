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
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained()->cascadeOnDelete();
            $table->foreignId('proposal_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('company_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('agency_id')->constrained('users')->cascadeOnDelete();
            $table->timestamp('last_message_at')->nullable()->index();
            $table->timestamps();

            $table->unique(['campaign_id', 'company_id', 'agency_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};
