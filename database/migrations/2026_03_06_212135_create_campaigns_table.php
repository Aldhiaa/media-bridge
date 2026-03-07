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
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->restrictOnDelete();
            $table->foreignId('industry_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('objective');
            $table->text('description');
            $table->text('target_audience')->nullable();
            $table->text('required_deliverables')->nullable();
            $table->decimal('budget', 12, 2);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->date('proposal_deadline');
            $table->boolean('allow_proposal_updates')->default(true);
            $table->enum('status', [
                'draft',
                'published',
                'receiving_proposals',
                'under_review',
                'awarded',
                'in_progress',
                'completed',
                'cancelled',
            ])->default('draft')->index();
            $table->boolean('is_featured')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->index(['company_id', 'status']);
            $table->index(['proposal_deadline', 'budget']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
