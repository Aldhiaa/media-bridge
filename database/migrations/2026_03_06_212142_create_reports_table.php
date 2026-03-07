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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reporter_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('reported_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('campaign_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('proposal_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('type', ['user', 'campaign', 'proposal', 'other'])->default('other')->index();
            $table->string('subject');
            $table->text('details');
            $table->enum('status', ['open', 'under_review', 'resolved', 'dismissed'])->default('open')->index();
            $table->foreignId('resolved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
