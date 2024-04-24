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
        Schema::create('friend_requests', function (Blueprint $table) {
            $table->string('uuid')->primary();
            $table->string('sender_uuid');
            $table->string('receiver_uuid');
            $table->timestamps();

            $table->foreign('sender_uuid')->references('uuid')->on('users');
            $table->foreign('receiver_uuid')->references('uuid')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('friend_requests');
    }
};
