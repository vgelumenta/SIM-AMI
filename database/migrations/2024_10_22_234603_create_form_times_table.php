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
        Schema::create('form_times', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_id')->nullable()->constrained()->onDelete('cascade');
            $table->datetime('submission_time')->nullable();
            $table->datetime('submission_deadline')->nullable();
            $table->boolean('submission_extended')->default(false);
            $table->datetime('assessment_time')->nullable();
            $table->datetime('assessment_deadline')->nullable();
            $table->boolean('assessment_extended')->default(false);
            $table->datetime('feedback_time')->nullable();
            $table->datetime('feedback_deadline')->nullable();
            $table->boolean('feedback_extended')->default(false);
            $table->datetime('verification_time')->nullable();
            $table->datetime('verification_deadline')->nullable();
            $table->boolean('verification_extended')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_submissions');
    }
};
