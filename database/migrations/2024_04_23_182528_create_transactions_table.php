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
        Schema::create('transactions', function (Blueprint $table) {
            $table->string('uuid')->primary();
            $table->string('remitent_wallet_uuid');
            $table->string('destination_wallet_uuid');
            $table->float('amount');
            $table->timestamps();

            $table->foreign('remitent_wallet_uuid')->references('uuid')->on('wallets');
            $table->foreign('destination_wallet_uuid')->references('uuid')->on('wallets');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
