<?php

use App\Auction\Domain\Models\Category;
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
        Schema::create('categories', function (Blueprint $table) {
            $table->string(Category::SERIALIZED_UUID)->primary();
            $table->string(Category::SERIALIZED_NAME)->unique();
            $table->string(Category::SERIALIZED_DESCRIPTION);
            $table->string(Category::SERIALIZED_AVATAR);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category');
    }
};
