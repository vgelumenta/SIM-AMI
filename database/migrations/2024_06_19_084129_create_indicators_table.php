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
        Schema::create('indicators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('competency_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('code');
            $table->text('assessment');
            $table->string('entry');
            $table->string('rate_option')->nullable();
            $table->string('disable_text')->nullable();
            $table->string('link_info')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indicators');
    }
};
