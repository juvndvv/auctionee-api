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
        Schema::create('user_auctions_favorites', function (Blueprint $table) {
            $table->id();
            $table->string('auction_uuid');
            $table->string('user_uuid');

            $table
                ->foreign('auction_uuid')
                ->references('uuid')
                ->on('auctions')
                ->onDelete('cascade');

            $table
                ->foreign('user_uuid')
                ->references('uuid')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_auctions_favorites');
    }
};
