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
        Schema::create('forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')->constrained()->onDelete('cascade');
            $table->foreignId('unit_id');
            $table->foreignId('stage_id');
            $table->string('meeting')->nullable();
            $table->datetime('meeting_time')->nullable();
            $table->boolean('meeting_verification')->nullable();
            $table->string('verification_info')->nullable();
            $table->string('signing')->nullable();
            $table->boolean('signing_verification')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forms');
    }
};
