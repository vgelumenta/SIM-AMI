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
        Schema::create('form_audits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('indicator_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('submission_status')->nullable();
            $table->string('validation')->nullable();
            $table->string('link')->nullable();
            $table->foreignId('assessment_status')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('feedback')->nullable();
            $table->text('comment')->nullable();
            $table->foreignId('verification_status')->nullable();
            $table->text('conclusion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_audits');
    }
};