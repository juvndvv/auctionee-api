<?php

use App\Financial\Domain\Models\Wallet;
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
        Schema::create('wallets', function (Blueprint $table) {
            $table->string(Wallet::UUID)->primary();
            $table->float(Wallet::BALANCE);
            $table->float(Wallet::BLOCKED_BALANCE)->default(0);
            $table->string(Wallet::USER_UUID);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};
