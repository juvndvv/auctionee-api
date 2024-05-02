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
        Schema::create('bids', function (Blueprint $table) {
            $table->string('uuid')->primary();
            $table->float('amount');
            $table->string('user_uuid');
            $table->string('auction_uuid');
            $table->timestamps();

            $table
                ->foreign('user_uuid')
                ->references('uuid')
                ->on('users')
                ->onDelete('cascade');

            $table
                ->foreign('auction_uuid')
                ->references('uuid')
                ->on('auctions')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bids');
    }
};
