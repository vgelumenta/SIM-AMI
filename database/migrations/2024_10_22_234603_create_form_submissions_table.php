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
        Schema::create('form_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_id')->nullable()->constrained()->onDelete('cascade');
            $table->datetime('submission')->nullable();
            $table->datetime('submission_deadline')->nullable();
            $table->boolean('submission_extended')->default(false);
            $table->datetime('assessment')->nullable();
            $table->datetime('assessment_deadline')->nullable();
            $table->boolean('assessment_extended')->default(false);
            $table->datetime('feedback')->nullable();
            $table->datetime('feedback_deadline')->nullable();
            $table->boolean('feedback_extended')->default(false);
            $table->datetime('verification')->nullable();
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
