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
        Schema::create('reviews', function (Blueprint $table) {
            $table->string('uuid')->primary();
            $table->string('reviewer_id');
            $table->string('reviewed_id');
            $table->text('review')->nullable();
            $table->tinyInteger('rating');
            $table->timestamps();

            $table->foreign('reviewed_id')->references('uuid')->on('users');
            $table->foreign('reviewer_id')->references('uuid')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
