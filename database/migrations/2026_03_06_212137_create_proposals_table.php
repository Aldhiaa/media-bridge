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
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained()->cascadeOnDelete();
            $table->foreignId('agency_id')->constrained('users')->cascadeOnDelete();
            $table->decimal('proposed_price', 12, 2);
            $table->text('strategy_summary');
            $table->string('execution_timeline');
            $table->text('relevant_experience')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['submitted', 'shortlisted', 'accepted', 'rejected', 'withdrawn'])
                ->default('submitted')
                ->index();
            $table->boolean('is_revision')->default(false);
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('shortlisted_at')->nullable();
            $table->timestamp('accepted_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->timestamps();

            $table->unique(['campaign_id', 'agency_id']);
            $table->index(['status', 'proposed_price']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposals');
    }
};
