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
            $table->string('reviewer_uuid');
            $table->string('reviewed_uuid');
            $table->text('description')->nullable();
            $table->tinyInteger('rating');
            $table->timestamps();

            $table->foreign('reviewed_uuid')->references('uuid')->on('users');
            $table->foreign('reviewer_uuid')->references('uuid')->on('users');
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
